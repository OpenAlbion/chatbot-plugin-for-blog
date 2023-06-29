<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('openalbion', function () {
            return Http::withHeaders([
                'X-WEAPONRY-KEY' => config('openalbion.api_key'),
            ])->baseUrl('https://api.openalbion.com/api/weaponryV2');
        });
    }
}
