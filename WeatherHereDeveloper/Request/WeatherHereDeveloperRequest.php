<?php

namespace MedeirosDev\WeatherHereDeveloper\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
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
    const BASE_URI = "https://maps.googleapis.com/maps/api/distancematrix/";

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

        $this->pushMiddleware(
            new LicenseMiddleware(
                new License()
            )
        );
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
            'origins'                    => $this->buildOrigins(),
            'destinations'               => $this->buildDestinations(),
            'mode'                       => $this->settings->getMode(),
            'units'                      => $this->settings->getUnits(),
            'avoid'                      => $this->settings->getAvoid(),
            'region'                     => $this->settings->getRegion(),
            'language'                   => $this->settings->getLanguage(),
            'arrival_time'               => $this->settings->getHourlyDate(),
            'departure_time'             => $this->settings->getDepartureTime(),
            'traffic_model'              => $this->settings->getTrafficModel(),
            'transit_mode'               => $this->buildTransitMode(),
            'transit_routing_preference' => $this->settings->getTransitRoutingPreference(),
        ]);

        return array_filter($options, function ($value) {
            return $value !== null || $value === "";
        });
    }

    /**
     * @return string
     */
    protected function buildOrigins()
    {
        return implode("|", $this->settings->getOrigins());
    }

    /**
     * @return string
     */
    protected function buildDestinations()
    {
        return implode("|", $this->settings->getDestinations());
    }

    /**
     * @return string
     */
    protected function buildTransitMode()
    {
        return implode("|", $this->settings->getTransitMode());
    }

    /**
     * @return WeatherHereDeveloperResponse
     */
    public function request()
    {
        return new WeatherHereDeveloperResponse(
            $this->guzzleHttpClient->get('json', [
                'query' => $this->buildQuery(),
            ])
        );
    }
}