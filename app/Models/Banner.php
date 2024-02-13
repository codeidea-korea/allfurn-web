<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'AF_banner_ad';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'idx','web_attachment_idx');
    }
}
