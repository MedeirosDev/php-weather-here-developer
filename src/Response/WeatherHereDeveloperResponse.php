<?php

namespace MedeirosDev\WeatherHereDeveloper\Response;

use MedeirosDev\WeatherHereDeveloper\Entities\Product;

use MedeirosDev\WeatherHereDeveloper\Entities\Unit;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\AlertNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\Forecast7DaysHourlyNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\Forecast7DaysNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\Forecast7DaysSimpleNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\ForecastAstronomyNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\ObservationNode;
use Psr\Http\Message\ResponseInterface;

use Symfony\Component\HttpFoundation\Response;

class WeatherHereDeveloperResponse
{
    const RESPONSE_OKAY = 'OK';
    const RESPONSE_INVALID_REQUEST = 'INVALID_REQUEST';
    const RESPONSE_MAX_ELEMENTS_EXCEEDED = 'MAX_ELEMENTS_EXCEEDED';
    const RESPONSE_OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    const RESPONSE_REQUEST_DENIED = 'REQUEST_DENIED';
    const RESPONSE_UNKNOWN_ERROR = 'UNKNOWN_ERROR';

    protected $response;
    public $json;

    public $product;
    public $nodes = [];
    public $feedCreation;
    public $metric;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->json = json_decode($response->getBody()->getContents());

        $this->fillProduct();
        $this->fillMetadata();
        $this->fillNodes();
    }

    public function successful(): bool
    {
        return $this->response->getStatusCode() === Response::HTTP_OK;
    }

    public function error(): bool
    {
        return $this->response->getStatusCode() !== Response::HTTP_OK;
    }

    public function isMetricUnit(): bool
    {
        return $this->metric === Unit::METRIC;
    }

    public function isImperialUnit(): bool
    {
        return $this->metric === Unit::IMPERIAL;
    }

    private function fillProduct(): void
    {
        if (property_exists($this->json, 'observations'))
            $this->product = Product::OBSERVATION;
        elseif (property_exists($this->json, 'forecasts'))
            $this->product = Product::FORECAST_7DAYS;
        elseif (property_exists($this->json, 'hourlyForecasts'))
            $this->product = Product::FORECAST_HOURLY;
        elseif (property_exists($this->json, 'dailyForecasts'))
            $this->product = Product::FORECAST_7DAYS_SIMPLE;
        elseif (property_exists($this->json, 'astronomy'))
            $this->product = Product::FORECAST_ASTRONOMY;
        elseif (property_exists($this->json, 'alerts'))
            $this->product = Product::ALERTS;
        else
            $this->product = Product::NWS_ALERTS;
    }

    private function fillMetadata(): void
    {
        $this->feedCreation = new \DateTime($this->json->feedCreation);
        $this->metric = $this->json->metric;
    }

    private function fillNodes(): void
    {
        switch ($this->product) {
            case Product::OBSERVATION:
                $this->fillNodesObservation();
                break;

            case Product::FORECAST_7DAYS:
                $this->fillNodes7Days();
                break;

            case Product::FORECAST_HOURLY:
                $this->fillNodes7DaysHourly();
                break;

            case Product::FORECAST_7DAYS_SIMPLE:
                $this->fillNodes7DaysSimple();
                break;

            case Product::FORECAST_ASTRONOMY:
                $this->fillNodesAstronomy();
                break;

            case Product::ALERTS:
                $this->fillNodesAlerts();
                break;

            case Product::NWS_ALERTS:
                $this->fillNodesNwsAlerts();
                break;
        }
    }

    private function fillNodesObservation(): void
    {
        $nodes = $this->json->observations->location;

        foreach ($nodes as $node) {
            $geo = $node;
            $node = $node->observation[0];
            $this->nodes[] = new ObservationNode($node, $geo);
        }
    }

    private function fillNodes7Days(): void
    {
        $nodes = $this->json->forecasts->forecastLocation->forecast;
        $geo = $this->json->forecasts->forecastLocation;

        foreach ($nodes as $node) {
            $this->nodes[] = new Forecast7DaysNode($node, $geo);
        }
    }

    private function fillNodes7DaysHourly(): void
    {
        $nodes = $this->json->hourlyForecasts->forecastLocation->forecast;
        $geo = $this->json->hourlyForecasts->forecastLocation;

        foreach ($nodes as $node) {
            $this->nodes[] = new Forecast7DaysHourlyNode($node, $geo);
        }
    }

    private function fillNodes7DaysSimple(): void
    {
        $nodes = $this->json->dailyForecasts->forecastLocation->forecast;
        $geo = $this->json->dailyForecasts->forecastLocation;

        foreach ($nodes as $node) {
            $this->nodes[] = new Forecast7DaysSimpleNode($node, $geo);
        }
    }

    private function fillNodesAstronomy(): void
    {
        $nodes = $this->json->astronomy->astronomy;
        $geo = $this->json->astronomy;

        foreach ($nodes as $node) {
            $this->nodes[] = new ForecastAstronomyNode($node, $geo);
        }
    }

    private function fillNodesAlerts(): void
    {
        $nodes = $this->json->alerts->alerts;
        $geo = $this->json->alerts;

        foreach ($nodes as $node) {
            $this->nodes[] = new AlertNode($node, $geo);
        }
    }

    private function fillNodesNwsAlerts(): void
    {
        if (property_exists($this->json, 'nwsAlerts')) {
            $this->nodes = $this->json->nwsAlerts;
        }
    }


}
