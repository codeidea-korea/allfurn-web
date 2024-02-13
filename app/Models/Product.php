<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Product extends Model
{
    protected $table = 'AF_product';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_idx','idx');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'category_idx','idx');
    }

}
