<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    protected $table = 'AF_reply';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_idx', 'idx');
    }
}
