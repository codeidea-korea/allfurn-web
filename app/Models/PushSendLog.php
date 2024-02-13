<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushSendLog extends Model
{
    protected $table = 'AF_push_send_log';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
