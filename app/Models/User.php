<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'AF_user';
    protected $primaryKey = 'idx';
    public $timestamps = false;
    const CREATED_AT = 'register_time';

    protected $fillable = [
        'account', 'secret',
    ];

    protected $hidden = [
        'secret',
    ];

    public function getAuthPassword()
    {
        return $this->attributes['secret'];
    }

    public function wholesale(): HasOne
    {
        return $this->hasOne(CompanyWholesale::class, 'idx', 'company_idx');
    }

    public function retail(): HasOne
    {
        return $this->hasOne(CompanyRetail::class, 'idx', 'company_idx');
    }
}
