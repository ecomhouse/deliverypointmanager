<?php

namespace EcomHouse\DeliveryPoints\Domain\DataBuilder;

class CsvBuilder implements DataBuilderInterface
{
    const FILE_EXTENSION = 'csv';
    private const DELIMITER = ',';

    public function build(string $filename, array $data, array $headers): void
    {
        $file = fopen($_ENV['FILE_PATH_DIRECTORY'] . $filename . '.' . self::FILE_EXTENSION, 'w');
        fputcsv($file, $headers, self::DELIMITER);

        foreach ($data as $row) {
            if (is_object($row)) {
                $row = $row->toArray();
            }
            fputcsv($file, $row);
        }

        fclose($file);
    }

    public function getFileExtension(): string
    {
        return self::FILE_EXTENSION;
    }
}