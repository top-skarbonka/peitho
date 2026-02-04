<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Firm;

class CheckSubscriptions extends Command
{
    protected $signature = 'subscriptions:check';
    protected $description = 'Auto block expired subscriptions';

    public function handle()
    {
        $now = now();

        $firms = Firm::whereNotNull('subscription_ends_at')->get();

        foreach ($firms as $firm) {

            /**
             * 🔴 FORCE BLOCK ma najwyższy priorytet
             */
            if ($firm->subscription_forced_status === 'blocked') {
                continue;
            }

            /**
             * ✅ Jeśli abonament aktywny → ACTIVE + AUTO UNBLOCK
             */
            if ($firm->subscription_ends_at->isFuture()) {

                $firm->update([
                    'subscription_status' => 'active',
                    'subscription_forced_status' => null // 🔥 AUTO UNBLOCK
                ]);

                continue;
            }

            /**
             * ⚠️ GRACE (7 dni)
             */
            $graceLimit = $firm->subscription_ends_at->copy()->addDays(7);

            if ($now->lessThan($graceLimit)) {

                $firm->update([
                    'subscription_status' => 'grace'
                ]);

            } else {

                /**
                 * 🔴 HARD BLOCK
                 */
                $firm->update([
                    'subscription_status' => 'blocked'
                ]);
            }
        }

        $this->info('Subscriptions checked successfully.');
    }
}
