<?php

namespace App\Providers;

use App\Events\UserRegisteredEvent;
use App\Events\UserUnregisteredEvent;
use Exception;
use Http;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

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
            try {
                Http::bot()->post('/registered', [
                    'user' => $event->user->load('tetrio'),
                    'tournament' => $event->tournament,
                ]);
            } catch (Exception $e) {
                // TODO: implement queue for failed notifs
                Log::error($e);
            }
        });

        Event::listen(function (UserUnregisteredEvent $event) {
            try {
                Http::bot()->post('/unregistered', [
                    'user' => $event->user->load('tetrio'),
                    'tournament' => $event->tournament,
                ]);
            } catch (Exception $e) {
                // TODO: implement queue for failed notifs
                Log::error($e);
            }
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
