<?php

namespace Domain\Service;

use Dotenv\Dotenv;
use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorApi;
use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\TestCase;

class InpostApiTest extends TestCase
{
    protected $inpostApi;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable('/var/www/html/config/');
        $dotenv->load();
        $this->inpostApi = new InpostApi(new ConnectorApi(new GuzzleClient), ['sandbox' => true]);
    }

    public function testGetPoints()
    {
        $response = $this->inpostApi->getPoints($_ENV['INPOST_API_TOKEN'], 1, 10);
        $points = json_decode($response->getBody());

        $this->assertNotEmpty($points->items);
    }
}