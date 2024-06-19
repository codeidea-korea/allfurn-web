<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
//    use SoftDeletes;

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
