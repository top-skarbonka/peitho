<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyCard extends Model
{
    protected $fillable = [
        'client_id',
        'firm_id',
        'max_stamps',
        'current_stamps',
        'status',
    ];

    protected $casts = [
        'current_stamps' => 'integer',
        'max_stamps'     => 'integer',
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
