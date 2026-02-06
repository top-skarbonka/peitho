<?php

namespace App\Services;

use App\Models\SecurityLog;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    /**
     * Zapis zdarzenia audytowego (RODO)
     */
    public static function log(
        string $action,
        string $actorType,
        int $actorId,
        ?int $targetId = null,
        array $meta = []
    ): void {
        SecurityLog::create([
            'action'      => $action,
            'actor_type'  => $actorType, // 'admin' | 'firm'
            'actor_id'    => $actorId,
            'target_id'   => $targetId,
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::userAgent(),
            'meta'        => $meta ? json_encode($meta) : null,
        ]);
    }
}
