<?php

namespace App\Listeners;

use App\Events\DeveloperCreated;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMessage
{
    public function handle(DeveloperCreated $event)
    {
        Mail::to($event->developer()->email)->send(new Welcome($event->developer()->name));
    }
}
