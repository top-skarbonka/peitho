<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Firm extends Authenticatable
{
    use HasFactory;

    protected $table = 'firms';

    /*
    |--------------------------------------------------------------------------
    | Mass assignable fields
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    | Hidden fields
    |--------------------------------------------------------------------------
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | Guard (auth)
    |--------------------------------------------------------------------------
    */
    protected $guard = 'company';

    /*
    |--------------------------------------------------------------------------
    | ROUTE MODEL BINDING
    |--------------------------------------------------------------------------
    | Dzięki temu {firm} w URL działa po firm_id, a nie po id
    | /register/card/{firm_id}
    */
    public function getRouteKeyName()
    {
        return 'firm_id';
    }

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
        return $this->hasMany(Voucher::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
