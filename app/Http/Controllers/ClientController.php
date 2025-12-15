    /*
    |--------------------------------------------------------------------------
    | KARTA LOJALNOŚCIOWA — DANE DLA PANELU KLIENTA
    |--------------------------------------------------------------------------
    */
    public function loyaltyCard()
    {
        $clientId = session('client_id');
        if (! $clientId) {
            abort(401);
        }

        $card = \App\Models\LoyaltyCard::where('client_id', $clientId)
            ->where('status', '!=', 'reset')
            ->first();

        if (! $card) {
            return response()->json(null);
        }

        return response()->json([
            'max_stamps'     => $card->max_stamps,
            'current_stamps' => $card->current_stamps,
            'completed'      => $card->status === 'completed',
            'reward'         => $card->reward,
        ]);
    }
