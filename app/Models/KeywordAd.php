<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeywordAd extends Model
{
    protected $table = 'AF_keyword_ad';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

}
