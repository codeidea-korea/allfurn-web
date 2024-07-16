<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QPushSend extends Model
{
    protected $table = 'Q_push_send';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'created_at';
}
