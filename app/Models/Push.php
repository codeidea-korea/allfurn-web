<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Push extends Model
{
    protected $table = 'AF_notification';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
