<?php

namespace EcomHouse\DeliveryPoints\Domain\DataBuilder;

class CsvBuilder implements DataBuilderInterface
{
    protected string $delimiter = ',';

    public function build(string $filename, array $data, array $headers)
    {
        $file = fopen(self::PATH_FILENAME . $filename . '.csv', 'w');
        fputcsv($file, $headers, $this->delimiter);

        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }

}