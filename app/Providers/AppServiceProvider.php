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
        Http::macro('aod', function (string $region, string $itemId) {
            return Http::timeout(3)
                ->get("http://{$region}.albion-online-data.com/api/v2/stats/prices/{$itemId}.json", [
                    'locations' => 'Caerleon,Bridgewatch,Lymhurst,Thetford,Martlock,Fort Sterling',
                    'qualities' => 1,
                ]);
        });
    }
}
