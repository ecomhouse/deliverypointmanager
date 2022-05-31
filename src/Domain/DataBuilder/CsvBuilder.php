<?php

namespace EcomHouse\DeliveryPoints\Domain\DataBuilder;

class CsvBuilder implements DataBuilderInterface
{
    private const DELIMITER = ',';

    public function build(string $filename, array $data, array $headers): void
    {
        $file = fopen(self::PATH_FILENAME . $filename . '.csv', 'w');
        fputcsv($file, $headers, self::DELIMITER);

        foreach ($data as $row) {
            fputcsv($file, $row->toArray());
        }

        fclose($file);
    }

}