<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftVoucher extends Model
{
    protected $fillable = [
        'program_id',
        'firm_id',
        'type',
        'amount',
        'service_name',
        'qr_code',
        'status',
        'valid_until',
        'recipient_name',
        'recipient_email',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
