<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

use EcomHouse\DeliveryPoints\Domain\DataBuilder\CsvBuilder;
use EcomHouse\DeliveryPoints\Domain\DataBuilder\XmlBuilder;
use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;

class GenerateFileCommand implements GenerateFileCommandInterface
{
    protected CsvBuilder $csvBuilder;
    protected XmlBuilder $xmlBuilder;

    public function __construct()
    {
        $this->csvBuilder = new CsvBuilder;
        $this->xmlBuilder = new XmlBuilder;
    }

    public function execute($data, string $filename, $speditor)
    {
        $data = DeliveryPointFactory::build($data, $speditor);
        $this->xmlBuilder->build($filename, $data, []);
        $this->csvBuilder->build($filename, $data, DeliveryPointFactory::getHeaders());
    }
}