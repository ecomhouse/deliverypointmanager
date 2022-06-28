<?php

namespace EcomHouse\DeliveryPoints\Infrastructure\Logger\Formatter;

use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;
use Monolog\Utils;

class JsonFormatter implements FormatterInterface
{
    private array $logLevels = [
        Logger::DEBUG => 7,
        Logger::INFO => 6,
        Logger::NOTICE => 5,
        Logger::WARNING => 4,
        Logger::ERROR => 3,
        Logger::CRITICAL => 2,
        Logger::ALERT => 1,
        Logger::EMERGENCY => 0,
    ];

    public function format(array|\Monolog\LogRecord $record): string
    {
        $record = $this->normalize((array)$record);

        $record['level'] = $this->logLevels[$record['level']->value];

        return Utils::jsonEncode($record, true) . ("\n");
    }

    public function formatBatch(array $records): string
    {
        $result = '';
        foreach ($records as $record) {
            $result .= $this->format($record);
        }

        return $result;
    }

    private function normalize(array $record): array
    {
        foreach ($record as $key => $field) {
            if (is_array($field)) {
                $record += $field;
                unset($record[$key]);
            }
        }

        return $record;
    }
}