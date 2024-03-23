<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomIdx;
    public $userIdx;
    public $message;
    public $contentHtml;
    public $date;
    public $times;
    public $dateOfWeek;
    public $title;
    public $roomName;

    public function __construct($roomIdx, $userIdx, $message, $contentHtml, $date, $times, $dateOfWeek, $title, $roomName)
    {
        $this->roomIdx = $roomIdx;
        $this->userIdx = $userIdx;
        $this->message = $message;
        $this->contentHtml = $contentHtml;
        $this->date = $date;
        $this->times = $times;
        $this->dateOfWeek = $dateOfWeek;
        $this->title = $title;
        $this->roomName = $roomName;
    }

    public function broadcastOn()
    {
        return ['user-cmd-' . $this->userIdx];
    }

    public function broadcastAs()
    {
        return 'user-cmd-event-' . $this->userIdx;
    }
}
