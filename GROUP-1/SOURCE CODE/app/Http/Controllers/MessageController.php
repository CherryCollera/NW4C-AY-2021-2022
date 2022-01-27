<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;

class MessageController extends Controller
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
            'msg_content' => ['required_without:msgimg_filepath'],
            'msgimg_filepath' => ['required_without:msg_content'],
        ])->validate();

        $newMessage = Message::create([
            'convo_id' => $request->convo_id,
            'sender_id' => $request->sender_id,
            'post_id' => $request->post_id,
            'content' => $request->msg_content,
            'image_path' => $request->msgimg_filepath,
            'is_read' => false
        ]);

        broadcast(new NewChatMessage($newMessage));

        return redirect()->back()
        ->with('message', 'message Created Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
    
    /**
     * Get messages from a conversation
     *
     * @param INT $convoID
     * @return JSON
     */
    public function getMessages($convoID)
    {
        $messages = Message::where('convo_id', $convoID)->get();
        return response()->json($messages);
    }

    /**
     * Get last message from a conversation
     *
     * @param INT $convoID
     * @return JSON
     */
    public function getLastMessage($convoID)
    {
        $messages = Message::where('convo_id', $convoID)->orderBy('created_at','desc')->first();
        return response()->json($messages);
    }

    /**
     * Processes the storing of image upload
     *
     * @param INT $convoID
     * @return JSON
     */
    public function storeImage(Request $request){
        if($request->hasFile('msgimg')){
            $file = $request->file('msgimg');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('public/msgimg/' . $folder , $filename);
            
            return 'msgimg/' . $folder . '/' . $filename;
        }

        broadcast(new NewChatMessage($newMessage));
        
        return '';
    }

    /**
     * Get Messages of User
     * 
     * @return JSON
     */
    public function getMessagesOfUser(){

        $conversations = Conversation::where('sender_user_id', Auth::user()->id)
                                ->orWhere('receiver_user_id', Auth::user()->id)
                                ->get();
        
        $conversations->transform(function ($conversation, $key) {
            return $conversation->id;
        });
        
        $messages = Message::whereIn('convo_id', $conversations)->get();
        
        return $messages;
    }
}
