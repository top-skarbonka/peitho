<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LoyaltyCard extends Model
{
    protected $fillable = [
        'program_id',
        'client_id',
        'max_stamps',
        'current_stamps',
        'reward',
        'qr_code',
        'status'
    ];

    protected $casts = [
        'current_stamps' => 'integer',
        'max_stamps'     => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACJE
    |--------------------------------------------------------------------------
    */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function stamps()
    {
        return $this->hasMany(LoyaltyStamp::class)->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIKA KARTY
    |--------------------------------------------------------------------------
    */

    public function addStamp(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->current_stamps >= $this->max_stamps) {
            $this->markCompleted();
            return false;
        }

        $this->increment('current_stamps');

        // ✅ JEDYNE POPRAWNE ŹRÓDŁO
        $firmId = session('firm_id');

        if (! $firmId) {
            throw new \Exception('Brak firm_id w sesji');
        }

        LoyaltyStamp::create([
            'loyalty_card_id' => $this->id,
            'firm_id'         => $firmId,
            'description'     => 'Dodano naklejkę',
        ]);

        if ($this->current_stamps >= $this->max_stamps) {
            $this->markCompleted();
        }

        return true;
    }

    public function resetAfterReward(): void
    {
        $this->update([
            'current_stamps' => 0,
            'status'         => 'active',
        ]);
    }

    protected function markCompleted(): void
    {
        $this->update([
            'status' => 'completed',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FABRYKA — JEDNA KARTA NA KLIENTA
    |--------------------------------------------------------------------------
    */
    public static function getOrCreateForClient(int $programId, int $clientId): self
    {
        return self::firstOrCreate(
            [
                'program_id' => $programId,
                'client_id'  => $clientId,
            ],
            [
                'max_stamps'     => 10,
                'current_stamps' => 0,
                'qr_code'        => Str::uuid()->toString(),
                'status'         => 'active',
            ]
        );
    }
}
