<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelHistory extends Model
{
    protected $table = 'AF_cancel_history';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
