<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'AF_order';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_idx', 'idx');
    }

    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_idx', 'idx');
    }
}
