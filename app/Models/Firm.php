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
        'google_review_url',

        // 🖼 logo
        'logo_path',

        // aktywność
        'last_activity_at',
        'password_changed_at',
    ];

    protected $hidden = [
        'password',
    ];

    // ✅ KLUCZ: dzięki temu last_activity_at będzie Carbonem, a nie stringiem
    protected $casts = [
        'last_activity_at'     => 'datetime',
        'password_changed_at'  => 'datetime',
        'created_at'           => 'datetime',
        'updated_at'           => 'datetime',
    ];

    /**
     * Routing po slugu
     */
    public function getRouteKeyName()
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
     * (Opcjonalnie) relacja – może się przydać w przyszłości,
     * ale nasz Activity i tak liczy po stamps.firm_id
     */
    public function loyaltyCards()
    {
        return $this->hasMany(\App\Models\LoyaltyCard::class);
    }
}
