<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInterestFolder extends Model
{
    protected $table = 'AF_product_interest_folder';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
