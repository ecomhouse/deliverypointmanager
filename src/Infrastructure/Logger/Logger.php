<?php

namespace EcomHouse\DeliveryPoints\Infrastructure\Logger;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;

class Logger extends \Monolog\Logger
{
    const PATH = '/var/www/html/var/log/logs.log';

    public function setHandlers(array $handlers): self
    {
        $streamHandler = new StreamHandler(self::PATH);
        $streamHandler->setFormatter(new JsonFormatter());
        $this->handlers = [$streamHandler];
        foreach (array_reverse($handlers) as $handler) {
            $this->pushHandler($handler);
        }

        return $this;
    }
}
