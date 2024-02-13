<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyNormal extends Model
{
    protected $table = 'AF_normal';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
