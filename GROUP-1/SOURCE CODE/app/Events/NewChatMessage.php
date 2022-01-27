<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatMessage;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->chatMessage->convo_id);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs() 
    {
        return "message.new";
    }
}
