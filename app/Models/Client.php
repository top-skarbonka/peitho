<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'program_id',
        'email',
        'phone',
        'city',
        'postal_code',
        'qr_code',
        'points',
    ];
}
