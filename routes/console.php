<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| AUTO BLOCK ENGINE 🔥
|--------------------------------------------------------------------------
*/

Schedule::command('subscriptions:check')
    ->everyMinute();
