<?php

namespace MedeirosDev\WeatherHereDeveloper\Tests\Integration\Products;

use Dotenv\Dotenv;
use MedeirosDev\WeatherHereDeveloper\Entities\Language;
use MedeirosDev\WeatherHereDeveloper\Entities\Location;
use MedeirosDev\WeatherHereDeveloper\Entities\Product;
use MedeirosDev\WeatherHereDeveloper\Licenses\License;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\Forecast7DaysHourlyNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\Forecast7DaysNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\ForecastAstronomyNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\GeoNode;
use MedeirosDev\WeatherHereDeveloper\WeatherHereDeveloper;
use PHPUnit\Framework\TestCase;

class ForecastAstronomyTest extends TestCase
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

    public function testForecastAstronomy(): void
    {
        $response = WeatherHereDeveloper::license($this->license)
            ->setProduct(Product::FORECAST_ASTRONOMY)
            ->setLanguage(Language::PORTUGUESE_BR)
            ->setLocation(Location::byName('Campinas - SP - Brazil'))
            ->request();

        $this->assertTrue($response->successful());
        $this->assertFalse($response->error());
        $this->assertGreaterThan(0, count($response->nodes));
        $this->assertTrue($response->isMetricUnit());
        $this->assertFalse($response->isImperialUnit());
    }

    public function testGeoNode(): void
    {
        $response = WeatherHereDeveloper::license($this->license)
            ->setProduct(Product::FORECAST_ASTRONOMY)
            ->setLanguage(Language::PORTUGUESE_BR)
            ->setLocation(Location::byName('Campinas - SP - Brazil'))
            ->setOneObservation()
            ->request();

        $node = $response->nodes[0];

        $this->assertTrue($response->successful());
        $this->assertInstanceOf(ForecastAstronomyNode::class, $node);
        $this->assertInstanceOf(GeoNode::class, $node->geo);
        $this->assertEquals('Brasil', $node->geo->country);
        $this->assertEquals('São Paulo', $node->geo->state);
        $this->assertEquals('Campinas', $node->geo->city);
        $this->assertEquals(-3, $node->geo->timezone);
    }

}
