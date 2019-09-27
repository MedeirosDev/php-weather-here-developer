<?php

namespace MedeirosDev\WeatherHereDeveloper;

use DateTime;
use MedeirosDev\WeatherHereDeveloper\Entities\Language;
use MedeirosDev\WeatherHereDeveloper\Entities\Location;
use MedeirosDev\WeatherHereDeveloper\Entities\Product;
use MedeirosDev\WeatherHereDeveloper\Entities\Unit;
use MedeirosDev\WeatherHereDeveloper\Exceptions\InvalidLanguageExpection;
use MedeirosDev\WeatherHereDeveloper\Exceptions\InvalidProductExpection;
use MedeirosDev\WeatherHereDeveloper\Request\WeatherHereDeveloperRequest;
use MedeirosDev\WeatherHereDeveloper\Response\WeatherHereDeveloperResponse;

class WeatherHereDeveloper
{

    protected $product;
    protected $location;
    protected $hourlyDate;
    protected $oneObservation = false;
    protected $language = Language::ENGLISH;
    protected $metric = Unit::METRIC;


    public function request(): WeatherHereDeveloperResponse
    {
        return (new WeatherHereDeveloperRequest($this))->request();
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        if (Helper::existsConstInClassByValue(Product::class, $product) === false) {
            throw new InvalidProductExpection("The product '{$product}' is invalid");
        }

        $this->product = $product;
        return $this;
    }


    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getHourlyDate(): ?DateTime
    {
        return $this->hourlyDate;
    }

    public function setHourlyDate(DateTime $hourlyDate): self
    {
        $this->hourlyDate = $hourlyDate;
        return $this;
    }

    public function getOneObservation(): bool
    {
        return $this->oneObservation;
    }

    public function setOneObservation(bool $oneObservation): self
    {
        $this->oneObservation = $oneObservation;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        if (Helper::existsConstInClassByValue(Language::class, $language) === false) {
            throw new InvalidLanguageExpection("The language '{$language}' is invalid");
        }

        $this->language = $language;
        return $this;
    }


    public function getMetric(): bool
    {
        return $this->metric;
    }

    public function setMetric(bool $metric): self
    {
        $this->metric = $metric;
        return $this;
    }

    public function useImperialUnit(): self
    {
        $this->setMetric(Unit::IMPERIAL);
        return $this;
    }

    public function useMetricUnit(): self
    {
        $this->setMetric(Unit::METRIC);
        return $this;
    }



}