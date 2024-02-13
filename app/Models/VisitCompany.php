<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitCompany extends Model
{
    protected $table = 'AF_company_visit';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
