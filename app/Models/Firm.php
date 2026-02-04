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
'subscription_status',
'subscription_ends_at',
'plan',
'billing_period',
'subscription_forced_status',
        // 🎨 karta
        'card_template',

        // 🔗 linki
        'facebook_url',
        'instagram_url',
        'google_url',

        // 🖼 logo
        'logo_path',
    ];

    protected $hidden = [
        'password',
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
}
