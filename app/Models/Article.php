<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $table = 'AF_board_article';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';
    const UPDATED_AT = 'update_time';

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'board_idx','idx');
    }

    public function like(): HasMany
    {
        return $this->hasMany(ArticleLike::class, 'article_idx', 'idx');
    }

    public function view(): HasMany
    {
        return $this->hasMany(ArticleView::class, 'article_idx', 'idx');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_idx', 'idx');
    }
}
