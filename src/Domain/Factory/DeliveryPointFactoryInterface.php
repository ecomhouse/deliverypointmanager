<?php

namespace EcomHouse\DeliveryPoints\Domain\Factory;

interface DeliveryPointFactoryInterface
{
    public static function build($data): array;
}