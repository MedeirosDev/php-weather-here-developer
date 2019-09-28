<?php


namespace MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities;

use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Traits\AutoFillNodeTrait;

class GeoNode
{
    public $country;
    public $state;
    public $city;
    public $latitude;
    public $longitude;
    public $distance;
    public $timezone;

    use AutoFillNodeTrait;

    public function __construct($responseGeo)
    {
        $this->fill($responseGeo);
    }

}
