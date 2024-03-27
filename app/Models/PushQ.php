<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushQ extends Model
{
    protected $table = 'AF_push';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
