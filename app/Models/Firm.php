<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Firm extends Authenticatable
{
    use HasFactory;

    protected $table = 'firms';

    /**
     * Pola masowo przypisywane
     */
    protected $fillable = [
        'firm_id',
        'name',
        'email',
        'password',
        'city',
        'address',
        'postal_code',
        'nip',
        'phone',
        'program_id',
    ];

    /**
     * Pola ukryte
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Auth guard – firma loguje się jako firma
     */
    protected $guard = 'firm';

    /*
    |--------------------------------------------------------------------------
    | RELACJE
    |--------------------------------------------------------------------------
    */

    public function loyaltyCards()
    {
        return $this->hasMany(LoyaltyCard::class);
    }

    public function stamps()
    {
        return $this->hasMany(LoyaltyStamp::class);
    }

    public function vouchers()
    {
        return $this->hasMany(GiftVoucher::class);
    }
}
