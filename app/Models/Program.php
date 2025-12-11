<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'points_rate',
        'subdomain',
        'points_name',
        'point_ratio',
    ];

    /**
     * Firmy przypisane do programu lojalnościowego.
     */
    public function firms()
    {
        return $this->hasMany(Firm::class);
    }

    /**
     * Klienci zarejestrowani w tym programie.
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
