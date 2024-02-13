<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyWholesale extends Model
{
    protected $table = 'AF_wholesale';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

    public function logo()
    {
        return $this->hasOne(Attachment::class, 'idx','logo_attachment');
    }

    public function profile()
    {
        return $this->hasOne(Attachment::class, 'idx','profile_image_attachment_idx');
    }

    public function likeCnt()
    {
        return $this->hasMany(LikeCompany::class, 'company_idx', 'idx')->with('company_type', 'W')->count();
    }

    public function visitCnt()
    {
        return $this->hasMany(VisitCompany::class, 'company_idx', 'idx')->with('company_type', 'W')->count();
    }
}
