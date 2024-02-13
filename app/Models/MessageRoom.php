<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageRoom extends Model
{
    protected $table = 'AF_message_room';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
