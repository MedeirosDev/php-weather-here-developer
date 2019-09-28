<?php

namespace MedeirosDev\WeatherHereDeveloper\Frameworks\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * Class WeatherHereDeveloper
 *
 * @package MedeirosDev\WeatherHereDeveloper\Frameworks\Laravel
 */
class WeatherHereDeveloper extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \MedeirosDev\WeatherHereDeveloper\WeatherHereDeveloper::class;
    }
}