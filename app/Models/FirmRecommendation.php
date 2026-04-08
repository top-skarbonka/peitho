<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmRecommendation extends Model
{
    use HasFactory;

    protected $table = 'firm_recommendations';

    protected $fillable = [
        'firm_id',
        'recommended_firm_id',
        'category_id',
        'promo_text',
        'sort_order',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function recommendedFirm()
    {
        return $this->belongsTo(Firm::class, 'recommended_firm_id');
    }

    public function category()
    {
        return $this->belongsTo(RecommendationCategory::class, 'category_id');
    }
}
