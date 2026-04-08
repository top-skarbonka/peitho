<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmLocation extends Model
{
    use HasFactory;

    protected $table = 'firm_locations';

    protected $fillable = [
        'firm_id',
        'name',
        'address',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'google_maps_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
