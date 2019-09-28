<?php

namespace MedeirosDev\WeatherHereDeveloper\Entities;


/**
 * Class Product
 * @package MedeirosDev\WeatherHereDeveloper\Entities
 */
abstract class Product
{
    const OBSERVATION = 'observation';
    const FORECAST_7DAYS = 'forecast_7days';
    const FORECAST_7DAYS_SIMPLE = 'forecast_7days_simple';
    const FORECAST_HOURLY = 'forecast_hourly';
    const FORECAST_ASTRONOMY = 'forecast_astronomy';
    const ALERTS = 'alerts';
    const NWS_ALERTS = 'nws_alerts';
}