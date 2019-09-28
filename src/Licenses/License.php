<?php

namespace MedeirosDev\WeatherHereDeveloper\Licenses;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Config;
use MedeirosDev\WeatherHereDeveloper\Contracts\LicenseContract;

/**
 * Class License
 *
 * @package MedeirosDev\WeatherHereDeveloper\Licenses
 */
class License
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
    private $app_code;

    /**
     * License constructor.
     * @param string $app_id
     * @param string $app_code
     */
    public function __construct(string $app_id, string $app_code)
    {
        $this->app_id = $app_id;
        $this->app_code = $app_code;
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