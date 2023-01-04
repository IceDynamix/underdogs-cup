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
        //
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
    }
}
