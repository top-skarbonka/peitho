<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| AUTO BLOCK ENGINE 🔥
|--------------------------------------------------------------------------
*/

Schedule::command('subscriptions:check')
    ->hourly();

/*
|--------------------------------------------------------------------------
| BACKUP SYSTEM 🛡
|--------------------------------------------------------------------------
| 06:00 rano
| 22:00 wieczorem
| cleanup 23:00
*/

Schedule::command('backup:run')
    ->dailyAt('06:00');

Schedule::command('backup:run')
    ->dailyAt('22:00');

Schedule::command('backup:clean')
    ->dailyAt('23:00');
