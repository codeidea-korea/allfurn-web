<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRecent extends Model
{
    protected $table = 'AF_recently_product';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
