<?php

namespace App\Listeners;

use App\Models\Developer;
use Illuminate\Support\Facades\Log;

class LogDevelopersCount
{
    public function handle(): void
    {
        Log::info('Developers count: ' . Developer::count());
    }
}
