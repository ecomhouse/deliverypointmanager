<?php
declare(strict_types=1);

namespace Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Service\OrlenApi;
use PHPUnit\Framework\TestCase;

final class OrlenTestApi extends TestCase
{
    protected OrlenApi $orlenApi;

    protected function setUp(): void
    {
        $this->orlenApi = new OrlenApi();
    }

    public function testGetPoints()
    {
        $response = $this->orlenApi->getPoints();
        $this->assertNotEmpty($response);
    }
}