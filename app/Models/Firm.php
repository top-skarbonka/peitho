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
        'password_changed_at',

        // 📍 Dane adresowe
        'city',
        'address',
        'postal_code',
        'phone',

        // 🎨 Wygląd / karta
        'card_template',
        'logo_path',

        // 🌍 Social / Google
        'google_url',
        'facebook_url',
        'instagram_url',
        'youtube_url',

        // 🎁 Promocje / godziny
        'promotion_text',
        'opening_hours',

        // 💳 Subskrypcja
        'plan',
        'billing_period',
        'subscription_status',
        'subscription_ends_at',
        'subscription_forced_status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
        'password_changed_at' => 'datetime',
    ];
}
