<?php

namespace Bluedot\LaravelBulkSms;

use Illuminate\Support\ServiceProvider;

class LaravelBulkSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-bulk-sms.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-bulk-sms');
        $this->app->singleton('laravel-bulk-sms', function () {
            return new LaravelBulkSms;
        });
    }
}
