<?php

namespace MedeirosDev\WeatherHereDeveloper\Licenses;

use GuzzleHttp\Psr7\Request;
use MedeirosDev\WeatherHereDeveloper\Contracts\LicenseContract;

/**
 * Class License
 *
 * @package MedeirosDev\WeatherHereDeveloper\Licenses
 */
class License implements LicenseContract
{
    /**
     * License App id
     *
     * @var string
     */
    private $app_id;

    /**
     * License App key
     *
     * @var string
     */
    private $app_key;

    /**
     * License constructor.
     *
     * @param string $key
     */
    public function __construct()
    {
        $this->app_id = config('here_developer.app_id');
        $this->app_code = config('here_developer.app_code');
    }

    /**
     * @param \GuzzleHttp\Psr7\Request $request
     *
     * @return array
     */
    public function getQueryStringParameters(Request $request): array
    {
        return [
            'app_id' => $this->app_id,
            'app_code' => $this->app_code,
        ];
    }
}