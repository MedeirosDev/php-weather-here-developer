<?php


namespace MedeirosDev\WeatherHereDeveloper\Response;


abstract class BaseNoneResponse
{
    public $daylight;
    public $description;
    public $skyInfo;
    public $skyDescription;
    public $temperatureDesc;
    public $comfort;
    public $humidity;
    public $dewPoint;
    public $precipitationDesc;
    public $airInfo;
    public $airDescription;
    public $windSpeed;
    public $windDirection;
    public $windDesc;
    public $windDescShort;
    public $icon;
    public $iconName;
    public $iconLink;
    public $utcTime;
}