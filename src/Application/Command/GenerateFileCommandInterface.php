<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

interface GenerateFileCommandInterface
{
    public function execute(array $data, string $filename);
}