<?php

namespace Domain\DataBuilder;

use Dotenv\Dotenv;
use EcomHouse\DeliveryPoints\Domain\DataBuilder\CsvBuilder;
use PHPUnit\Framework\TestCase;

final class CsvBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable('/var/www/html/config/');
        $dotenv->load();
    }

    public function testBuild()
    {
        $headers = [
            'delivery-point-x',
            'delivery-point-y',
            'delivery-point-code'
        ];

        $data = [
            ['Column1', 'Column2', 'Column3'],
            ['Column1', 'Column2', 'Column3'],
            ['Column1', 'Column2', 'Column3']
        ];

        $filename = "/var/www/html/var/data/speditor";
        $csvBuilder = new CsvBuilder;
        $csvBuilder->build('speditor', $data, $headers);

        $this->assertFileExists($filename.'.csv');

        unlink($filename.'.csv');
    }
}