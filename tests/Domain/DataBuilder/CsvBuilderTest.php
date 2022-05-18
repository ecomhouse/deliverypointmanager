<?php

namespace Domain\DataBuilder;

use Dotenv\Dotenv;
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
        $filename = "/var/www/html/var/data/" . $_ENV['INPOST_DELIVERY_POINTS_FILENAME']. '.csv';

        $this->assertTrue(file_exists($filename));
    }
}