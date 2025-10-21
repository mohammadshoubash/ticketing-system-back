<?php

use App\Jobs\RemoveTokens;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new RemoveTokens)->dailyAt('00:00');
