<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscribeBoard extends Model
{
    protected $table = 'AF_board_subscribe';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

    public function board()
    {
        return $this->hasOne(Board::class, 'idx','board_idx');
    }
}
