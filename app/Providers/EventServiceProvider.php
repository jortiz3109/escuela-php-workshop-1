<?php

namespace App\Providers;

use App\Events\DeveloperCreated;
use App\Listeners\LogDeveloperCreation;
use App\Listeners\LogDevelopersCount;
use App\Listeners\SendWelcomeMessage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        DeveloperCreated::class => [
            SendWelcomeMessage::class,
            LogDeveloperCreation::class,
            LogDevelopersCount::class,
        ],
    ];
}
