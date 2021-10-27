<?php

namespace App\Listeners;

use App\Events\DeveloperCreated;
use App\Models\Developer;
use Illuminate\Support\Facades\Log;

class LogDevelopersCount
{
    public function handle(DeveloperCreated $event): void
    {
        Log::info('Developers count: ' . Developer::count());
    }
}
