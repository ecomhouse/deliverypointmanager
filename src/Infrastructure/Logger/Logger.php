<?php

namespace EcomHouse\DeliveryPoints\Infrastructure\Logger;

use EcomHouse\DeliveryPoints\Infrastructure\Logger\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;

class Logger extends \Monolog\Logger
{
    const PATH = 'var/log/delivery-points.log';

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
