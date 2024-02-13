<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryHistory extends Model
{
    protected $table = 'AF_user_category_history';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
