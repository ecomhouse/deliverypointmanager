<?php

namespace EcomHouse\DeliveryPoints\Domain\DataBuilder;

interface DataBuilderInterface
{
    public function build(string $filename, array $data, array $headers): void;
    public function getFileExtension(): string;
}