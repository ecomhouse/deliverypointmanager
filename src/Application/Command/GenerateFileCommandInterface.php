<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

interface GenerateFileCommandInterface
{
    public function execute($data, string $filename, string $speditor);
}