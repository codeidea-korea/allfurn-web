<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlimtalkTemplate extends Model
{
    protected $table = 'AF_alimtalk_template';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
