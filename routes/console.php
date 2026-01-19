<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::command('backup:run --only-db')->timezone('Europe/Madrid')->daily()->at('03:01');
Schedule::command('backup:run')->timezone('Europe/Madrid')->sundays()->at('03:05');
