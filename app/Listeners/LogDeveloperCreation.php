<?php

namespace App\Listeners;

use App\Events\DeveloperCreated;
use Illuminate\Support\Facades\Log;

class LogDeveloperCreation
{
    public function handle(DeveloperCreated $event): void
    {
        Log::info('New developer created', $event->developer()->toArray());
    }
}
