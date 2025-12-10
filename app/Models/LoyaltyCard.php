<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyCard extends Model
{
    protected $fillable = [
        'program_id',
        'client_id',
        'max_stamps',
        'current_stamps',
        'reward',
        'qr_code',
        'status'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function stamps()
    {
        return $this->hasMany(LoyaltyStamp::class);
    }
}
