<?php

namespace Infrastructure\Logger;

use EcomHouse\DeliveryPoints\Infrastructure\Logger\Logger;
use Monolog\Logger as LoggerAlias;
use Monolog\Handler\StreamHandler;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    const PATH = 'var/log/delivery-points-test.log';
    private Logger $logger;

    protected function setUp(): void
    {
        $this->logger = new Logger('default');
    }

    public function testInfo()
    {
        $this->logger->pushHandler(new StreamHandler(self::PATH, LoggerAlias::INFO));
        $this->logger->info('This is a log!');

        $this->assertFileExists(self::PATH);
        unlink(self::PATH);
    }
}