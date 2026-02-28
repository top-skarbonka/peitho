<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToFirm;

class RegistrationToken extends Model
{
    use HasFactory;
    use BelongsToFirm;

    protected $fillable = [
        'token',
        'firm_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACJE
    |--------------------------------------------------------------------------
    */

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
