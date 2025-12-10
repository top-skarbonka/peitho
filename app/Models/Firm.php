<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Firm extends Authenticatable
{
    use HasFactory;

    protected $table = 'firms';

    protected $fillable = [
        'firm_id',
        'name',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function vouchers()
    {
        return $this->hasMany(GiftVoucher::class);
    }

    public function stamps()
    {
        return $this->hasMany(LoyaltyStamp::class);
    }
}
