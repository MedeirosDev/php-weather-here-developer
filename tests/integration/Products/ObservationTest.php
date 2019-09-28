<?php

namespace MedeirosDev\WeatherHereDeveloper\Tests\Integration\Products;

use Dotenv\Dotenv;
use MedeirosDev\WeatherHereDeveloper\Entities\Language;
use MedeirosDev\WeatherHereDeveloper\Entities\Location;
use MedeirosDev\WeatherHereDeveloper\Entities\Product;
use MedeirosDev\WeatherHereDeveloper\Entities\Unit;
use MedeirosDev\WeatherHereDeveloper\Licenses\License;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\GeoNode;
use MedeirosDev\WeatherHereDeveloper\Response\Nodes\Entities\ObservationNode;
use MedeirosDev\WeatherHereDeveloper\WeatherHereDeveloper;
use PHPUnit\Framework\TestCase;

class ObservationTest extends TestCase
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

    public function testObservations(): void
    {
        $response = WeatherHereDeveloper::license($this->license)
            ->setProduct(Product::OBSERVATION)
            ->setLanguage(Language::PORTUGUESE_BR)
            ->setLocation(Location::byName('Campinas - SP - Brazil'))
            ->request();

        $this->assertTrue($response->successful());
        $this->assertFalse($response->error());
        $this->assertGreaterThan(0, count($response->nodes));
        $this->assertTrue($response->isMetricUnit());
        $this->assertFalse($response->isImperialUnit());
    }

    public function testOneObservation(): void
    {
        $response = WeatherHereDeveloper::license($this->license)
            ->setProduct(Product::OBSERVATION)
            ->setLanguage(Language::PORTUGUESE_BR)
            ->setLocation(Location::byName('Campinas - SP - Brazil'))
            ->setOneObservation()
            ->request();

        $this->assertTrue($response->successful());
        $this->assertEquals(1, count($response->nodes));
        $this->assertInstanceOf(ObservationNode::class, $response->nodes[0]);
    }

    public function testGeoNode(): void
    {
        $response = WeatherHereDeveloper::license($this->license)
            ->setProduct(Product::OBSERVATION)
            ->setLanguage(Language::PORTUGUESE_BR)
            ->setLocation(Location::byName('Campinas - SP - Brazil'))
            ->setOneObservation()
            ->request();

        $observation = $response->nodes[0];

        $this->assertTrue($response->successful());
        $this->assertInstanceOf(ObservationNode::class, $observation);
        $this->assertInstanceOf(GeoNode::class, $observation->geo);
        $this->assertEquals('Brasil', $observation->geo->country);
        $this->assertEquals('São Paulo', $observation->geo->state);
        $this->assertEquals('Campinas', $observation->geo->city);
        $this->assertEquals(-3, $observation->geo->timezone);
    }

}
