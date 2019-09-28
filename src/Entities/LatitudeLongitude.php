<?php


namespace MedeirosDev\WeatherHereDeveloper\Entities;


class LatitudeLongitude
{
    public $latitude;
    public $longitude;

    public function __construct($longitude, $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

}