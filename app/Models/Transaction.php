<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'client_id',
        'firm_id',
        'program_id',
        'type',
        'amount',
        'points',
        'note',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
