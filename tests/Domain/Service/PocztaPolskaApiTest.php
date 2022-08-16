<?php
declare(strict_types=1);

namespace Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Service\PocztaPolskaApi;
use PHPUnit\Framework\TestCase;

class PocztaPolskaApiTest extends TestCase
{
    protected PocztaPolskaApi $pocztaPolskaApi;

    protected function setUp(): void
    {
        $this->pocztaPolskaApi = new PocztaPolskaApi();
    }

    public function testGetPoints()
    {
        $response = $this->pocztaPolskaApi->getPoints();
        $this->assertNotEmpty($response);
    }
}