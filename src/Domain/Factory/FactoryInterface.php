<?php

namespace EcomHouse\DeliveryPoints\Domain\Factory;

interface FactoryInterface
{
    public static function getHeaders(): array;
    public static function build(array $data, string $speditor);
}