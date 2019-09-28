<?php

namespace MedeirosDev\WeatherHereDeveloper\Stack;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use MedeirosDev\WeatherHereDeveloper\Licenses\License;

class LicenseMiddleware
{
    /**
     * @var \MedeirosDev\WeatherHereDeveloper\Licenses\License
     */
    protected $license;

    /**
     * LicenseMiddleware constructor.
     *
     * @param \MedeirosDev\WeatherHereDeveloper\Licenses\License $license
     */
    public function __construct(License $license)
    {
        $this->license = $license;
    }

    /**
     * @param callable $next
     *
     * @return \Closure
     */
    public function __invoke(callable $next)
    {
        return function (RequestInterface $request, array $options) use ($next) {
            return $next($this->addLicense($request), $options);
        };
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function addLicense(RequestInterface $request)
    {
        $query = $this->license->getQueryStringParameters($request);

        if (count($query)) {
            foreach ($query as $key => $value) {
                $request = $request->withUri(Uri::withQueryValue($request->getUri(), $key, $value));
            }
        }

        return $request;
    }
}