<?php

namespace Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Service\DhlApi;
use PHPUnit\Framework\TestCase;

final class DhlApiTest extends TestCase
{
    protected DhlApi $dhlApi;

    protected function setUp(): void
    {
        $this->dhlApi = new DhlApi();
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