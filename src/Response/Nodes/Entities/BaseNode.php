<?php

namespace MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities;

use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Traits\AutoFillNodeTrait;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Interfaces\IFillGeoNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Interfaces\IFillNode;

abstract class BaseNode implements IFillNode, IFillGeoNode
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

    public $geo;

    use AutoFillNodeTrait;
}
