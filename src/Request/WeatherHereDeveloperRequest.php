<?php

namespace MedeirosDev\WeatherHereDeveloper\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use MedeirosDev\WeatherHereDeveloper\Helper;
use MedeirosDev\WeatherHereDeveloper\Licenses\License;
use MedeirosDev\WeatherHereDeveloper\WeatherHereDeveloper;
use MedeirosDev\WeatherHereDeveloper\Response\WeatherHereDeveloperResponse;
use MedeirosDev\WeatherHereDeveloper\Stack\LicenseMiddleware;

/**
 * Class WeatherHereDeveloperRequest
 *
 * @package MedeirosDev\WeatherHereDeveloper
 */
class WeatherHereDeveloperRequest
{
    const BASE_URI = 'https://weather.api.here.com/weather/1.0/';

    protected $settings;
    protected $guzzleHttpClient;
    protected $handlerStack;

    /**
     * WeatherHereDeveloperRequest constructor.
     *
     * @param WeatherHereDeveloper          $settings
     * @param MockHandler|CurlHandler|null $handler
     */
    public function __construct(WeatherHereDeveloper $settings, $handler = null)
    {
        $this->settings = $settings;
        $this->handlerStack    = HandlerStack::create($handler ?? new CurlHandler());
        $this->guzzleHttpClient   = new Client([
            'base_uri' => static::BASE_URI,
            'handler'  => $this->handlerStack,
        ]);

        $this->pushMiddleware(new LicenseMiddleware($this->settings->getLicense()));
    }

    /**
     * @param callable $middleware
     *
     * @return $this
     */
    public function pushMiddleware(callable $middleware)
    {
        $this->handlerStack->push($middleware);

        return $this;
    }

    /**
     * @return array
     */
    protected function buildQuery()
    {
        $options = array_merge([
            'product' => $this->settings->getProduct(),
            'latitude' => $this->settings->getLocation()->getLatitude(),
            'longitude' => $this->settings->getLocation()->getLongitude(),
            'name' => $this->settings->getLocation()->getName(),
            'zipcode' => $this->settings->getLocation()->getZipcode(),
            'oneobservation' => $this->buildOneObservation(),
            'language' => $this->settings->getLanguage(),
            'hourlydate' => $this->buildHourlydate(),
            'metric' => $this->buildMetric(),
        ]);

        return array_filter($options, function ($value) {
            return $value !== null || $value === '';
        });
    }

    protected function buildHourlydate(): ?string
    {
        $date = $this->settings->getHourlyDate();

        if ($date instanceof \DateTime) {
            return $date->format('Y-m-d\TH:i:s');
        }

        return null;
    }

    private function buildOneObservation()
    {
        return Helper::booleanToString($this->settings->getOneObservation());
    }

    private function buildMetric()
    {
        return Helper::booleanToString($this->settings->getMetric());
    }

    /**
     * @return WeatherHereDeveloperResponse
     */
    public function request()
    {
        return new WeatherHereDeveloperResponse(
            $this->guzzleHttpClient->get('report.json', [
                'query' => $this->buildQuery(),
            ])
        );
    }
}