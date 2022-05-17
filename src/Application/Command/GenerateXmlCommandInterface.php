<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

interface GenerateXmlCommandInterface
{
    public function execute(string $token, string $filename);
}