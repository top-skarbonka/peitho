<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'clients';

    /**
     * ✅ Pola masowo zapisywane (RODO + rejestracja)
     */
    protected $fillable = [
        'firm_id',
        'program_id',

        'name',
        'email',
        'phone',
        'city',
        'postal_code',

        'password',
        'password_set',

        // ✅ ZGODY RODO
        'sms_marketing_consent',
        'sms_marketing_consent_at',
        'terms_accepted_at',

        // inne
        'points',
        'activation_token',
        'activation_token_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * ✅ Rzutowania – ważne przy RODO
     */
    protected $casts = [
        'password'                     => 'hashed',
        'sms_marketing_consent'         => 'boolean',
        'sms_marketing_consent_at'      => 'datetime',
        'terms_accepted_at'             => 'datetime',
        'activation_token_expires_at'   => 'datetime',
    ];
}
