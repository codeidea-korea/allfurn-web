<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estimate extends Model {
    protected $table = 'AF_estimate';
    protected $primaryKey = 'idx';

    public $timestamps = false;
    const CREATED_AT = 'register_time';
}