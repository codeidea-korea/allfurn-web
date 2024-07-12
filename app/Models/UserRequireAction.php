<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequireAction extends Model
{
    protected $table = 'AF_user_require_action';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'created_at';
}
