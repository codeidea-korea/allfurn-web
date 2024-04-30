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
    public $userIdx;
    public $companyIdx;
    public $comnd;
    public $message;
    public $contentHtml;
    public $date;
    public $times;
    public $dateOfWeek;
    public $title;
    public $roomName;

    public function __construct($roomIdx, $userIdx, $companyIdx, $comnd, $message, $contentHtml, $date, $times, $dateOfWeek, $title, $roomName)
    {
        $this->roomIdx = $roomIdx;
        $this->userIdx = $userIdx;
        $this->companyIdx = $companyIdx;
        $this->comnd = $comnd;
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
        return ['chat-' . $this->roomIdx];
    }

    public function broadcastAs()
    {
        return 'chat-event-' . $this->roomIdx;
    }
}
