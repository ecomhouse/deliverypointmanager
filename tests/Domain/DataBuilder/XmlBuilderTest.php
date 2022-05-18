<?php

namespace Domain\DataBuilder;

use Dotenv\Dotenv;
use EcomHouse\DeliveryPoints\Domain\DataBuilder\XmlBuilder;
use PHPUnit\Framework\TestCase;

final class XmlBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable('/var/www/html/config/');
        $dotenv->load();
    }

    public function testBuild()
    {
        $filename = "/var/www/html/var/data/" . $_ENV['INPOST_DELIVERY_POINTS_FILENAME'];
        $data[] = [
            'delivery-point-x' => '0.00',
            'delivery-point-y' => '0.00',
            'delivery-point-code' => 'code',
            'delivery-point-type' => 'type',
            'delivery-point-address' => 'street',
            'delivery-point-city' => 'city',
            'delivery-point-postcode' => 'postcode',
            'delivery-point-comment' => 'comment',
        ];

        $xmlBuilder = new XmlBuilder;
        $xmlBuilder->build($_ENV['INPOST_DELIVERY_POINTS_FILENAME'], $data, []);

        $this->assertFileExists($filename.'.xml');

        unlink($filename.'.xml');
    }
}