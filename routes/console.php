<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('shoutcast:poll')->everyThirtySeconds();
Schedule::command('daily:fetch')->dailyAt('00:05');
Schedule::command('kktc:scrape')->twiceDaily(8, 20);   // Sabah 08:00 + Akşam 20:00
Schedule::command('evkaf:scrape')->dailyAt('09:00');
