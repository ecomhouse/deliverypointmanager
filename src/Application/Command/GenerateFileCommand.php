<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

use EcomHouse\DeliveryPoints\Domain\DataBuilder\CsvBuilder;
use EcomHouse\DeliveryPoints\Domain\DataBuilder\XmlBuilder;
use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use EcomHouse\DeliveryPoints\Domain\Helper\FileExtension;

class GenerateFileCommand implements GenerateFileCommandInterface
{
    private array $dataBuilder = [];

    public function __construct(array $config = [])
    {
        foreach ($config as $param) {
            $this->dataBuilder[] = match ($param) {
                FileExtension::XML => new XmlBuilder,
                FileExtension::CSV => new CsvBuilder
            };
        }
    }

    public function execute($data, string $filename)
    {
        foreach ($this->dataBuilder as $dataBuilder) {
            $dataBuilder->build($filename, $data, DeliveryPointFactory::getHeaders());
        }
    }
}