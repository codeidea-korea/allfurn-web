<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomIdx;
    public $sender;
    public $message;
    public $sentAt;

    public function __construct($roomIdx, $sender, $message, $sentAt)
    {
        $this->roomIdx = $roomIdx;
        $this->sender = $sender;
        $this->message = $message;
        $this->sentAt = $sentAt;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat-' . $roomIdx);
    }
}
