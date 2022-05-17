<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

interface GenerateCsvCommandInterface
{
    public function execute(string $token, string $filename);
}