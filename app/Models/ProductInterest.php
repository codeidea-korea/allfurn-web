<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInterest extends Model
{
    protected $table = 'AF_product_interest';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
