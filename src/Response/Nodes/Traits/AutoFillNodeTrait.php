<?php


namespace MedeirosDev\WeatherHereDeveloper\Response\Nodes\Traits;

use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\GeoNode;

trait AutoFillNodeTrait
{
    public function __construct($responseNode, $responseGeo)
    {
        $this->fill($responseNode);
        $this->fillGeo($responseGeo);
    }

    public function fill($response): void
    {
        foreach ($response as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    public function fillGeo($response): void
    {
        $this->geo = new GeoNode($response);
    }
}