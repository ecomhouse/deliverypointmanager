<?php

namespace EcomHouse\DeliveryPoints\Domain\DataBuilder;

interface DataBuilderInterface
{
    const PATH_FILENAME = 'var/data/';

    public function build(string $filename, $data);
}