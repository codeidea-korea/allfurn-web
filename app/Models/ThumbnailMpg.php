<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThumbnailMpg extends Model
{
    protected $table = 'AF_mapping_thumb_attachment';
    protected $primaryKey = 'idx';
    public $timestamps = false;
}
