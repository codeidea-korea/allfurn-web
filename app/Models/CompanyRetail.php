<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyRetail extends Model
{
    protected $table = 'AF_retail';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
