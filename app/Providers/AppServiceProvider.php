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
            $this->app->singleton(KafkaService::class, function ($app) {
                return new KafkaService(config('services.kafka'));
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
