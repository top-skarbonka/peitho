<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        /**
         * 🔥 AUTO BLOCK ENGINE
         */
        $schedule->command('subscriptions:check')
            ->hourly();

        /**
         * 🛡 BACKUP SYSTEM – PRODUKCJA
         * 06:00 rano
         * 22:00 wieczorem
         */
        $schedule->command('backup:run')
            ->dailyAt('06:00');

        $schedule->command('backup:run')
            ->dailyAt('22:00');

        /**
         * 🧹 Cleanup starych backupów
         */
        $schedule->command('backup:clean')
            ->dailyAt('23:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
