<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityLog extends Model
{
    /**
     * Tabela w bazie
     */
    protected $table = 'security_logs';

    /**
     * Nie używamy updated_at
     */
    public const UPDATED_AT = null;

    /**
     * Pola do masowego zapisu
     */
    protected $fillable = [
        'actor_type',   // admin / system
        'actor_id',     // ID admina
        'action',       // np. export_consents
        'target',       // np. firm_id=16
        'ip_address',
        'user_agent',
        'created_at',
    ];
}
