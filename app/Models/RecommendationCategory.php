<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationCategory extends Model
{
    use HasFactory;

    protected $table = 'recommendation_categories';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function recommendations()
    {
        return $this->hasMany(FirmRecommendation::class, 'category_id');
    }
}
