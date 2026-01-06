<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Firm extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'firm_id',
        'slug',
        'name',
        'email',
        'password',
        'program_id',
        'city',
        'address',
        'postal_code',
        'nip',
        'phone',

        // 🔑 NOWE
        'card_template',
        'facebook_url',
        'instagram_url',
        'google_url',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
