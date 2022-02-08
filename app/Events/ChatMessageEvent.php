<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ChatMessageEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $senderId;
    public $receiverId;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($senderId,$receiverId,$message)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(){
//        return new Channel('chat'.$this->senderId.$this->receiverId);
        return new Channel('chat');
    }

    /**
     * @return string
     * @event name
     */
    public function broadcastAs(){
        return 'ChatEvent';
    }
    /**
     * @return array
     * @event data
     */
    public function broadcastWith(){
        return ["data"=>$this->message];
    }
}
