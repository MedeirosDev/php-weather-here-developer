<?php

namespace MedeirosDev\WeatherHereDeveloper\Frameworks\Laravel;

use Illuminate\Support\ServiceProvider;
use MedeirosDev\WeatherHereDeveloper\WeatherHereDeveloper;

class WeatherHereDeveloperServiceProvider extends ServiceProvider
{
    /**
     * Register our packages services.
     */
    public function register()
    {
        $this->app->bind(WeatherHereDeveloper::class, function () {
            return new WeatherHereDeveloper();
        });
    }

    /**
     * Boot our packages services
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/here_developer.php', 'here_developer');

        $this->publishes([
            __DIR__ . '/here_developer.php' => config_path('here_developer.php'),
        ], 'config');
    }

}