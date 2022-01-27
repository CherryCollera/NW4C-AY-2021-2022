<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barter;
use App\Models\Message;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;

class BarterController extends Controller
{
    /**
     * Creates a new Post
     *
     * @return Response
     */
    public function startBarter(Request $request){
        Barter::create([
            'convo_id' => $request->convo_id,
            'post_id' => $request->post_id,
        ]);

        $newMessage = Message::create([
            'convo_id' => $request->convo_id,
            'sender_id' => Auth::user()->id,
            'content' => 'J0bZVYAygIsovtriXs23uXejc6bU85BjWQuTM8aeEptFCEeDlWmB5Uh41LoqhNaBQAV8EGkP6aRkcW8YE5ed2J8ygrk78yyM6xSxzRBzIwCVvXZHEDSnj96d0sAhLlzqaSMmPUsL4QIyqQbO0BxHqCCo65iNXzsWpP7KvTmq4LMtMPnY3YLA4a6EYixkgBEddE0XY3po2MjnpUgODprZkzJNgS3l9A4KOQnabCEjw2mCuIYKPZrCAB1VGTLYnj8H',
            'is_read' => false
        ]);

        broadcast(new NewChatMessage($newMessage));

        return redirect()->back()
        ->with('message', 'Barter Created Succesfully');
    }

    /**
     * Checks if a barter has already been started
     *
     * @return Boolean
     */
    public function barterExists($convoID){

        $barterExists = Barter::where('convo_id', $convoID)->get();
        return $barterExists->isEmpty() ? response()->json(false) : response()->json(true);

    }

     /**
     * Checks if a barter is done
     *
     * @return Boolean
     */
    public function isDone($convoID){

        $barterDone = Barter::where('convo_id', $convoID)->first();
        
        if(isset($barterDone->finished_at)){
            return response()->json(true);
        }else{
            return response()->json(false);
        }

        return $barterDone->isEmpty() ? response()->json(false) : response()->json(true);
    }
}
