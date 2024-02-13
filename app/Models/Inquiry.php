<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inquiry extends Model
{
    protected $table = 'AF_inquiry';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

    public function category(): HasOne
    {
        return $this->hasOne(InquiryCategory::class, 'idx', 'category_idx');
    }
}
