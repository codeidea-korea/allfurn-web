<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomIdx;
    public $message;
    public $contentHtml;
    public $date;
    public $times;

    public function __construct($roomIdx, $message, $contentHtml, $date, $times)
    {
        $this->roomIdx = $roomIdx;
        $this->message = $message;
        $this->contentHtml = $contentHtml;
        $this->date = $date;
        $this->times = $times;
    }

    public function broadcastOn()
    {
        return ['chat-' . $this->roomIdx];
    }

    public function broadcastAs()
    {
        return 'chat-event-' . $this->roomIdx;
    }
}
