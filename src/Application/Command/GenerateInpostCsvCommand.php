<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;

class GenerateInpostCsvCommand implements GenerateCsvCommandInterface
{
    protected InpostApi $inpostApi;

    public function __construct(InpostApi $inpostApi)
    {
        $this->inpostApi = $inpostApi;
    }

    public function execute()
    {

    }
}