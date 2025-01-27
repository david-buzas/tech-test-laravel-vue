<?php

namespace App\Providers;

use app\Services\Countries\CountriesThirdPartyApiClient;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CountriesThirdPartyApiClient::class, function () {
            return new CountriesThirdPartyApiClient(
                new Client(),
                Log::channel('api'),
                config('api.countries_api.uri'),
                config('api.countries_api.options'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
