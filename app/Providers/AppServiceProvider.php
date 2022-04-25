<?php

namespace App\Providers;

use App\Factories\ValidationFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->extend('validator', function () {
            return $this->app->get(ValidationFactory::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
