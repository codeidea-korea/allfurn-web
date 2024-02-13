<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryProperty extends Model
{
    protected $table = 'AF_category_property';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_idx','idx');
    }
}
