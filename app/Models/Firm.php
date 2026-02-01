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

        // 🎨 karta
        'card_template',

        // 🔗 linki
        'facebook_url',
        'instagram_url',
        'google_url',

        // 🖼 logo
        'logo_path',

        // 📊 aktywność
        'last_activity_at',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Route model binding po slugu
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Pełny URL logo (jeśli istnieje)
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo_path) {
            return null;
        }

        return asset('storage/' . $this->logo_path);
    }

    /**
     * Karty lojalnościowe firmy
     */
    public function loyaltyCards()
    {
        return $this->hasMany(\App\Models\LoyaltyCard::class);
    }
}
