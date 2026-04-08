<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmPromotion extends Model
{
    use HasFactory;

    protected $table = 'firm_promotions';

    protected $fillable = [
        'firm_id',
        'title',
        'promo_text',
        'image_path',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
