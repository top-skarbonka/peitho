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

        // 🆕 Typ programu
        'program_type',

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

        // 📢 Premium push
        'push_enabled',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
        'password_changed_at' => 'datetime',
        'push_enabled' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACJE
    |--------------------------------------------------------------------------
    */

    public function promotions()
    {
        return $this->hasMany(\App\Models\FirmPromotion::class);
    }

    public function locations()
    {
        return $this->hasMany(\App\Models\FirmLocation::class);
    }

    public function recommendations()
    {
        return $this->hasMany(\App\Models\FirmRecommendation::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERY
    |--------------------------------------------------------------------------
    */

    public function isCards(): bool
    {
        return $this->program_type === 'cards';
    }

    public function isPasses(): bool
    {
        return $this->program_type === 'passes';
    }
}
