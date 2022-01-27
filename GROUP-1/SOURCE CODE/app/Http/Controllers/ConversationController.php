<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Category;
use App\Models\QuantityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ConversationController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
    
    /**
     * Display messages page of controller
     *
     * @return Inertia
     */
    public function showConversations()
    {
        $conversations = Conversation::with(['message'])
        ->where('sender_user_id', Auth::user()->id)
        ->orWhere('receiver_user_id', Auth::user()->id)
        ->latest()
        ->get();

        $categories = Category::orderBy('id', 'asc')->get();
        $qtyType = QuantityType::orderBy('id', 'asc')->get();

        return Inertia::render('Messages', [
        'conversations' => $conversations,
        'categories' => $categories,
        'qtyType' => $qtyType,
        ]);
    }
    
    /**
     * Get a conversation
     *
     * @return JSON
     */
    public function getConversation($convoID)
    {
        $conversations = Conversation::with(['message'])
        ->where('id', $convoID)
        ->orWhere('sender_user_id', Auth::user()->id)
        ->orWhere('receiver_user_id', Auth::user()->id)
        ->get();

        return response()->json($conversations[0]);
    }

    /**
     * Get convo from post
     *
     * @return JSON
     */
    public function getConvoFromPost($postID){

        $conversation = Conversation::where('post_id', $postID)->get();

        return response()->json($conversation[0]);

    }

    /**
     * Get all conversations
     *
     * @return JSON
     */
    public function getConversations()
    {
        $conversations = Conversation::with(['message'])
        ->where('sender_user_id', Auth::user()->id)
        ->orWhere('receiver_user_id', Auth::user()->id)
        ->get();

        return response()->json($conversations);
    }

}
