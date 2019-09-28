<?php

namespace MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities;

use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Traits\AutoFillNodeTrait;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Interfaces\IFillGeoNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Interfaces\IFillNode;

class ForecastAstronomyNode implements IFillNode, IFillGeoNode
{
    public $sunrise;
    public $sunset;
    public $moonrise;
    public $moonset;
    public $moonPhase;
    public $moonPhaseDesc;
    public $iconName;
    public $city;
    public $latitude;
    public $longitude;
    public $utcTime;

    public $geo;

    use AutoFillNodeTrait;

}
