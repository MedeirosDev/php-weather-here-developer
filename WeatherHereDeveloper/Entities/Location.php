<?php


namespace MedeirosDev\WeatherHereDeveloper\Entities;

/**
 * Class Location
 * @package MedeirosDev\WeatherHereDeveloper\Entities
 */
class Location
{
    const LATITUDE_LONGITUDE = 'latitude_longitude';
    const NAME = 'name';
    const ZIPCODE = 'zipcode';

    protected $by;

    protected $latitude;
    protected $longitude;
    protected $name;
    protected $zipcode;


    public function byLatitudeLongitude(string $latitude, string $longitude): void
    {
        $this->by = self::LATITUDE_LONGITUDE;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function byName(string $name): void
    {
        $this->by = self::NAME;
        $this->name = $name;
    }

    public function byZipcode(string $zipcode): void
    {
        $this->by = self::ZIPCODE;
        $this->zipcode = $zipcode;
    }
}