<?php

namespace EcomHouse\DeliveryPoints\Domain\DataBuilder;

class CsvBuilder implements DataBuilderInterface
{
    protected string $delimiter = ',';

    public function build(string $filename, $data)
    {
        // TODO: Implement build() method.
    }

    protected function setHeader(int $offset): array
    {
        return [];
    }

}