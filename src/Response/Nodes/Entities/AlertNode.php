<?php


namespace MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities;

use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Traits\AutoFillNodeTrait;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Interfaces\IFillGeoNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Interfaces\IFillNode;

class AlertNode implements IFillNode, IFillGeoNode
{
    public $type;
    public $description;
    public $timeSegment;

    public $geo;

    use AutoFillNodeTrait;

}
