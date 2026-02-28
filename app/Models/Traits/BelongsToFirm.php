<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToFirm
{
    /**
     * Global scope – automatyczna izolacja danych per firma
     * Działa WYŁĄCZNIE w panelu firmy (prefix company/*)
     */
    protected static function bootBelongsToFirm(): void
    {
        static::addGlobalScope('firm', function (Builder $builder) {

            if (
                request()->is('company/*') &&
                Auth::guard('company')->check()
            ) {
                $firm = Auth::guard('company')->user();

                $builder->where(
                    $builder->getModel()->getTable() . '.firm_id',
                    $firm->id
                );
            }
        });
    }

    /**
     * Manualny scope (gdy chcemy jawnie filtrować)
     */
    public function scopeForFirm(Builder $query, int $firmId): Builder
    {
        return $query->where(
            $this->getTable() . '.firm_id',
            $firmId
        );
    }
}
