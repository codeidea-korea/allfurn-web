<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessagePushBlock extends Model
{
    protected $table = 'AF_message_push_block';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
