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
     * ✅ KLUCZOWA POPRAWKA:
     * musimy pozwolić na masowe ustawianie program_id (i opcjonalnie firm_id),
     * bo register używa updateOrCreate / create.
     */
    protected $fillable = [
        'phone',
        'password',
        'program_id',
        'firm_id',

        // jeśli masz te kolumny i czasem je ustawiasz:
        'email',
        'city',
        'postal_code',
        'points',
        'password_set',
        'activation_token',
        'activation_token_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'activation_token_expires_at' => 'datetime',
    ];
}
