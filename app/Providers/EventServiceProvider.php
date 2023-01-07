<?php

namespace App\Providers;

use App\Events\UserRegisteredEvent;
use App\Events\UserUnregisteredEvent;
use Http;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(function (UserRegisteredEvent $event) {
            Http::bot()->post('/registered', [
                'user' => $event->user->with('tetrio'),
                'tournament' => $event->tournament
            ]);
        });

        Event::listen(function (UserUnregisteredEvent $event) {
            Http::bot()->post('/unregistered', [
                'user' => $event->user->with('tetrio'),
                'tournament' => $event->tournament
            ]);
        });
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
