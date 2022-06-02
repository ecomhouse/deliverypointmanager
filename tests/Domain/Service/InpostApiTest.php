<?php

namespace Domain\Service;

use Dotenv\Dotenv;
use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorApi;
use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\TestCase;

class InpostApiTest extends TestCase
{
    protected InpostApi $inpostApi;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable('/var/www/html/config/');
        $dotenv->load();
        $this->inpostApi = new InpostApi(new ConnectorApi(new GuzzleClient));
    }

    public function testGetPoints()
    {
        $response = $this->inpostApi->getPoints(['page' => 1, 'per_page' => 10]);
        $this->assertNotEmpty($response);
    }

    public function testGetCountPoints()
    {
        $result = $this->inpostApi->getCountPoints();
        $this->assertGreaterThan(0, $result);
    }

}