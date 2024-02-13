<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthWholesaleSetting extends Model
{
    protected $table = 'AF_month_wholesale_setting';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
