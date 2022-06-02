<?php

namespace Domain\Service;

use Dotenv\Dotenv;
use EcomHouse\DeliveryPoints\Domain\Service\DhlApi;
use PHPUnit\Framework\TestCase;

class DhlApiTest extends TestCase
{
    protected DhlApi $dhlApi;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable('/var/www/html/config/');
        $dotenv->load();
        $this->dhlApi = new DhlApi([
            'sandbox' => $_ENV['SANDBOX'],
            'username' => $_ENV['DHL_API_USER'],
            'password' => $_ENV['DHL_API_PASSWORD'],
            'country' => 'PL',
            'postcode' => '00110',
            'city' => 'Warszawa',
            'radius' => 500,
        ]);
    }

    public function testGetPoints()
    {
        $points = $this->dhlApi->getPoints();

        $this->assertNotEmpty($points);
    }

    public function testGetPointsIsArray()
    {
        $points = $this->dhlApi->getPoints();

        $this->assertIsArray($points);
    }

}