<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryCategory extends Model
{
    protected $table = 'AF_inquiry_category';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
