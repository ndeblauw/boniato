<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the IpServiceInterface to a concrete implementation.
        // The concrete class can be provided via config('services.ip_service')
        // It may be a full class name or a short name like 'ipinfo' or 'ipstack'.
        $this->app->singleton(\App\Services\IpServiceInterface::class, function ($app) {
            $config = config('services.ip_service');

            if( !in_array($config, ['ipinfo', 'ipstack'])) {
                abort(500, "Invalid IP service configuration: {$config}");
            }

            $class = match($config) {
                'ipinfo' => \App\Services\IpInfoService::class,
                'ipstack' => \App\Services\IpStackService::class,
                default => null, // todo, provide default for error handling
            };

            return $app->make($class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Model::shouldBeStrict( !app()->isProduction());
    }
}
