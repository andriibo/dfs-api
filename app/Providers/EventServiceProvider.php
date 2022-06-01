<?php

namespace App\Providers;

use App\Events\UserActivatedEvent;
use App\Events\UserOAuthActivatedEvent;
use App\Listeners\SendEmailPasswordListener;
use App\Listeners\SendEmailWelcomeListener;
use App\Listeners\UserActivatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserActivatedEvent::class => [
            UserActivatedListener::class,
            SendEmailWelcomeListener::class,
        ],
        UserOAuthActivatedEvent::class => [
            UserActivatedListener::class,
            SendEmailPasswordListener::class,
            SendEmailWelcomeListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
