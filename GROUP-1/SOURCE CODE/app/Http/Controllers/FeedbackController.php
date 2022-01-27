<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Feedback;
use App\Models\Message;
use App\Models\Post;
use App\Models\Offer;
use App\Models\Barter;
use App\Events\NewChatMessage;


class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'rating' => ['required', 'numeric', 'gt:0'],
            'postID' => ['required'],
            'receiver' => ['required'],
            'sender' => ['required'],
            'convoID' => ['required'],
        ])->validate();

        Feedback::create([
            'rater_user_id' => Auth::user()->id,
            'ratee_user_id' => $request->receiver === Auth::user()->id ? $request->sender : $request->receiver,
            'post_id' => $request->postID,
            'description' => $request->feedbackMessage,
            'amount' => $request->rating,
        ]);

        $newMessage = Message::create([
            'convo_id' => $request->convoID,
            'sender_id' => Auth::user()->id,
            'content' => 'lCKgxW4lj8cUGg2nnqGziCsw7pp9uJo4xHFOIS9THC0r5OOdhZZvTL8HJNzUXUv7qajYPqcw9VY4HrEjox0NcR13jp8dSXpaUYsh8yxEAtvCxQ6HGbNKTRe2kvJBT16XBTIjtIcM669bPbuxs27VvMtThBkZfznEgRcZvP3sZH5Eq1g9VbPsBVSb4kdaAGA41vC6xmfW7YZFM8MWY0QrjnzoMiwSrAf0hCE5XlErHZpCH9IRI913yDx7m5S1PBjO',
            'is_read' => false
        ]);

        Barter::where('convo_id', $request->convoID)
                ->update([
                    'finished_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ]);

        Post::where('id', $request->postID)
            ->update([
                'status' => 'sold'
            ]);
        
        Offer::where('post_id', $request->postID)
            ->update([
                'status' => 'sold'
            ]);
        

        // @TODO EDIT post status to sold, offer status to sold

        broadcast(new NewChatMessage($newMessage));

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Feedback Created!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Feedback Created Succesfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'rating' => ['required', 'numeric', 'gt:0'],
        ])->validate();

        Feedback::where('id',$request['feedback']['id'])->update(['amount' => $request->rating, 'description' => $request->feedbackMessage]);

        $request->session()->flash('flash.bannerId', uniqid());
        $request->session()->flash('flash.banner', 'Feedback Updated!');
        $request->session()->flash('flash.bannerStyle', 'success');

        return redirect()->back()
                    ->with('message', 'Feedback Updated Succesfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get feedback
     *
     */
    public function getFeedback($postID)
    {
        $feedbacks = Feedback::where('post_id', $postID)->get();

        return response()->json($feedbacks);
    }

    /**
     * Get all feedbacks of a user
     *
     */
    public function getUserFeedbacks($userID){
        $feedbacks = Feedback::where('ratee_user_id', $userID)->get();

        return response()->json($feedbacks->count());
    }

    /**
     * Get all feedbacks of a user
     *
     */
    public function getAllFeedback($userID){
        $feedbacks = Feedback::where('ratee_user_id', $userID)->get();

        return response()->json($feedbacks);
    }
}
