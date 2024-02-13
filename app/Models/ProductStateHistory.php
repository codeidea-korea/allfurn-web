<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStateHistory extends Model
{
    protected $table = 'AF_product_state_history';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
