<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubArticleLike extends Model
{
    protected $table = 'AF_club_article_like';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
}
