<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAuthCode extends Model
{
    protected $table = 'AF_user_authcode';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
