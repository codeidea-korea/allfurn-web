<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPushSet extends Model
{
    protected $table = 'AF_user_push_set';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
