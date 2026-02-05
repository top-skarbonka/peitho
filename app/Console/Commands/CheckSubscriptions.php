<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Firm;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionReminderMail;
use App\Mail\SubscriptionExpiredMail;
use App\Mail\SubscriptionBlockedMail;

class CheckSubscriptions extends Command
{
    protected $signature = 'subscriptions:check';
    protected $description = 'Auto block expired subscriptions (with mail dedupe)';

    public function handle(): int
    {
        $now = now();

        Firm::whereNotNull('subscription_ends_at')
            ->orderBy('id')
            ->chunkById(200, function ($firms) use ($now) {

                foreach ($firms as $firm) {

                    // 0) FORCE BLOCK ma najwyższy priorytet
                    if ($firm->subscription_forced_status === 'blocked') {
                        continue;
                    }

                    // 1) REMINDER: 7 dni przed końcem (tylko raz)
                    // Warunek: ends_at w przyszłości i <= 7 dni
                    if (
                        $firm->subscription_ends_at->isFuture()
                        && $firm->subscription_ends_at->diffInDays($now) <= 7
                    ) {
                        // Atomiczne "zarezerwowanie" wysyłki - tylko jeśli flaga jest NULL
                        $updated = Firm::where('id', $firm->id)
                            ->whereNull('subscription_reminder_sent_at')
                            ->update(['subscription_reminder_sent_at' => now()]);

                        if ($updated) {
                            Mail::to($firm->email)->queue(new SubscriptionReminderMail($firm));
                        }
                    }

                    // 2) AKTYWNY
                    if ($firm->subscription_ends_at->isFuture()) {
                        if ($firm->subscription_status !== 'active') {
                            $firm->update(['subscription_status' => 'active']);
                        }
                        continue;
                    }

                    // 3) EXPIRED (pierwszy raz po terminie) -> status grace + mail raz
                    $updatedExpired = Firm::where('id', $firm->id)
                        ->whereNull('subscription_expired_sent_at')
                        ->update([
                            'subscription_expired_sent_at' => now(),
                            'subscription_status' => 'grace',
                        ]);

                    if ($updatedExpired) {
                        Mail::to($firm->email)->queue(new SubscriptionExpiredMail($firm));
                        // po wysłaniu "expired" nie sprawdzamy dalej tej iteracji
                        continue;
                    }

                    // 4) PO 7 DNIACH -> BLOCK + mail raz
                    $graceLimit = $firm->subscription_ends_at->copy()->addDays(7);

                    if ($now->greaterThanOrEqualTo($graceLimit)) {

                        $updatedBlocked = Firm::where('id', $firm->id)
                            ->whereNull('subscription_blocked_sent_at')
                            ->update([
                                'subscription_blocked_sent_at' => now(),
                                'subscription_status' => 'blocked',
                            ]);

                        if ($updatedBlocked) {
                            Mail::to($firm->email)->queue(new SubscriptionBlockedMail($firm));
                        }
                    }
                }
            });

        $this->info('Subscriptions checked successfully.');
        return self::SUCCESS;
    }
}
