<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUpgradeQueue extends Model
{
    protected $table = 'AF_user_upgrade_queue';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
