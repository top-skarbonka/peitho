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

    // 🎨 WYGLĄD / KARTA
    'card_template',

    // 🔗 LINKI
    'facebook_url',
    'instagram_url',
    'google_url',
    'google_review_url',

    // 💰 BILLING / SAAS
    'subscription_status',
    'subscription_ends_at',
    'plan',
    'billing_period',
    'subscription_forced_status',
];
    protected $hidden = [
        'password',
    ];

    /**
     * 🔥 KLUCZOWE — CAST DATY
     */
    protected $casts = [
        'subscription_ends_at' => 'datetime',
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
     * 🔥 SERCE SaaS — czy firma jest zablokowana
     */
    public function isBlocked(): bool
    {
        // admin override
        if ($this->subscription_forced_status === 'active') {
            return false;
        }

        if ($this->subscription_forced_status === 'blocked') {
            return true;
        }

        // brak daty → traktujemy jako aktywną
        if (!$this->subscription_ends_at) {
            return false;
        }

        return now()->greaterThan(
            $this->subscription_ends_at->copy()->addDays(3)
        );
    }
}
