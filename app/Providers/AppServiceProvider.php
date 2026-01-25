<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\IpServiceInterface::class, function ($app) {
            $service = config('services.ip_service', 'ipinfo');

            $class = match ($service) {
                'ipinfo' => \App\Services\IpInfoService::class,
                'ipstack' => \App\Services\IpStackService::class,
                default => throw new \Exception('Unsupported IP service: '.$service),
            };

            return $app->make($class);
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Model::shouldBeStrict( !app()->isProduction());
    }
}
