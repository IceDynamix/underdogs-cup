<?php

namespace App\Providers;

use App\Events\UserRegisteredEvent;
use App\Events\UserUnregisteredEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;

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
            Redis::publish('register', json_encode(['user' => $event->user, 'tournament' => $event->tournament]));
        });

        Event::listen(function (UserUnregisteredEvent $event) {
            Redis::publish('unregister', json_encode([
                'user' => $event->user,
                'tournament' => $event->tournament,
                'reasons' => $event->reasons,
            ]));
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
