<?php

namespace MedeirosDev\WeatherHereDeveloper;

use DateTime;
use MedeirosDev\WeatherHereDeveloper\Entities\Language;
use MedeirosDev\WeatherHereDeveloper\Entities\Location;
use MedeirosDev\WeatherHereDeveloper\Entities\Product;
use MedeirosDev\WeatherHereDeveloper\Entities\Unit;
use MedeirosDev\WeatherHereDeveloper\Exceptions\InvalidLanguageExpection;
use MedeirosDev\WeatherHereDeveloper\Exceptions\InvalidProductExpection;
use MedeirosDev\WeatherHereDeveloper\Licenses\License;
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
    protected $license;

    public function __construct(License $license = null)
    {
        $this->autoLicense($license);
    }

    public function request(): WeatherHereDeveloperResponse
    {
        return (new WeatherHereDeveloperRequest($this))->request();
    }

    public static function license(License $license): self {
        return new static($license);
    }

    private function autoLicense(License $license): self {

        if ($license) {
            $this->license = $license;

        } elseif (Helper::getFramework() === 'Laravel') {
            $this->license = new License(
                config('here_developer.app_id'),
                config('here_developer.app_code')
            );
        }

        return $this;
    }

    public function getLicense(): ?License
    {
        return $this->license;
    }

    public function setLicense(License $license): self
    {
        $this->license = $license;
        return $this;
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

    public function setOneObservation(bool $oneObservation = true): self
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