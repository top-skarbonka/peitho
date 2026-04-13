<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToFirm;

class LoyaltyCard extends Model
{
    use BelongsToFirm;

    protected $fillable = [
        'client_id',
        'firm_id',
        'max_stamps',
        'current_stamps',
        'status',
        'marketing_consent',
        'marketing_consent_at',
        'marketing_consent_revoked_at',
        'sms_marketing_consent',
        'sms_marketing_consent_at',
        'sms_marketing_consent_revoked_at',
        'email_marketing_consent',
        'email_marketing_consent_at',
        'email_marketing_consent_revoked_at',
        'push_consent',
        'push_consent_at',
        'push_consent_revoked_at',
    ];

    protected $casts = [
        'current_stamps'                     => 'integer',
        'max_stamps'                         => 'integer',
        'marketing_consent'                  => 'boolean',
        'marketing_consent_at'               => 'datetime',
        'marketing_consent_revoked_at'       => 'datetime',
        'sms_marketing_consent'              => 'boolean',
        'sms_marketing_consent_at'           => 'datetime',
        'sms_marketing_consent_revoked_at'   => 'datetime',
        'email_marketing_consent'            => 'boolean',
        'email_marketing_consent_at'         => 'datetime',
        'email_marketing_consent_revoked_at' => 'datetime',
        'push_consent'                       => 'boolean',
        'push_consent_at'                    => 'datetime',
        'push_consent_revoked_at'            => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACJE
    |--------------------------------------------------------------------------
    */

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function stamps()
    {
        return $this->hasMany(LoyaltyStamp::class)->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIKA
    |--------------------------------------------------------------------------
    */

    public function isCompleted(): bool
    {
        return $this->current_stamps >= $this->max_stamps;
    }
}
