<?php

namespace MedeirosDev\WeatherHereDeveloper\Tests\Integration\Products;

use Dotenv\Dotenv;
use MedeirosDev\WeatherHereDeveloper\Entities\Language;
use MedeirosDev\WeatherHereDeveloper\Entities\Location;
use MedeirosDev\WeatherHereDeveloper\Entities\Product;
use MedeirosDev\WeatherHereDeveloper\Licenses\License;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\AlertNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\Forecast7DaysHourlyNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\Forecast7DaysNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\ForecastAstronomyNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\GeoNode;
use MedeirosDev\WeatherHereDeveloper\WeatherHereDeveloper;
use PHPUnit\Framework\TestCase;

class AlertsTest extends TestCase
{

    protected $app_id;
    protected $app_code;
    protected $license;

    protected function setUp(): void
    {
        parent::setUp();

        (new Dotenv(__DIR__ . '/../../../'))->load();

        $this->app_id = getenv('HERE_DEVELOPER_APP_ID');
        $this->app_code = getenv('HERE_DEVELOPER_APP_CODE');

        $this->license = new License($this->app_id, $this->app_code);
    }

    public function testAlerts(): void
    {
        $response = WeatherHereDeveloper::license($this->license)
            ->setProduct(Product::ALERTS)
            ->setLanguage(Language::PORTUGUESE_BR)
            ->setLocation(Location::byName('Campinas - SP - Brazil'))
            ->request();

        $this->assertTrue($response->successful());
        $this->assertFalse($response->error());
        $this->assertTrue($response->isMetricUnit());
        $this->assertFalse($response->isImperialUnit());
    }

    public function testJsonGeo(): void
    {
        $response = WeatherHereDeveloper::license($this->license)
            ->setProduct(Product::ALERTS)
            ->setLanguage(Language::PORTUGUESE_BR)
            ->setLocation(Location::byName('Campinas - SP - Brazil'))
            ->setOneObservation()
            ->request();

        $this->assertTrue($response->successful());
        $this->assertEquals('Brasil', $response->json->alerts->country);
        $this->assertEquals('São Paulo', $response->json->alerts->state);
        $this->assertEquals('Campinas', $response->json->alerts->city);
        $this->assertEquals(-3, $response->json->alerts->timezone);
    }

}
