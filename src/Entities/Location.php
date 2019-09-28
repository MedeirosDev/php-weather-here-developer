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

    protected $latitudeLongitude;
    protected $name;
    protected $zipcode;


    public static function byLatitudeLongitude(string $latitude, string $longitude): self {
        return (new static())->setLatitudeLongitude($latitude, $longitude);
    }

    public static function byName(string $name): self {
        return (new static())->setName($name);
    }

    public static function byZipcode(string $zipcode): self {
        return (new static())->setZipcode($zipcode);
    }

    protected function clear(): self
    {
        $this->latitudeLongitude = null;
        $this->name = null;
        $this->zipcode = null;
        return $this;
    }

    public function setLatitudeLongitude(string $latitude, string $longitude): self
    {
        $this->clear();
        $this->by = self::LATITUDE_LONGITUDE;
        $this->latitudeLongitude = new LatitudeLongitude($latitude, $longitude);
        return $this;
    }

    public function setName(string $name): self
    {
        $this->clear();
        $this->by = self::NAME;
        $this->name = $name;
        return $this;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->clear();
        $this->by = self::ZIPCODE;
        $this->zipcode = $zipcode;
        return $this;
    }

    public function getLatitudeLongitude(): ?LatitudeLongitude
    {
        return $this->latitudeLongitude;
    }

    public function getLatitude(): ?string
    {
        return $this->getLatitudeLongitude()->latitude ?? null;
    }

    public function getLongitude(): ?string
    {
        return $this->getLatitudeLongitude()->longitude ?? null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function getBy(): ?string
    {
        return $this->by;
    }
}