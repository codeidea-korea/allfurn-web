<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    protected $table = 'AF_sms_history';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
