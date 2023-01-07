<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Http::macro('tetrio', function () {
            $session = config()->get('services.tetrio.session');

            return Http::withHeaders(['X-Session-Header' => $session])
                ->baseUrl('https://ch.tetr.io/api');
        });

        Http::macro('discord', function () {
            return Http::baseUrl('https://discord.com/api/v10');
        });

        Http::macro('bot', function () {
            return Http::baseUrl(config()->get('services.discord.bot_url'));
        });
    }
}
