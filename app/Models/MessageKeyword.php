<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageKeyword extends Model
{
    protected $table = 'AF_message_search_keyword';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
