<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToFirm;

class LoyaltyStamp extends Model
{
    use BelongsToFirm;

    protected $fillable = [
        'loyalty_card_id',
        'firm_id',
        'description'
    ];

    public function card()
    {
        return $this->belongsTo(LoyaltyCard::class, 'loyalty_card_id');
    }

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
