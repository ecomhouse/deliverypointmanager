<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

use EcomHouse\DeliveryPoints\Domain\DataBuilder\CsvBuilder;
use EcomHouse\DeliveryPoints\Domain\DataBuilder\XmlBuilder;
use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use EcomHouse\DeliveryPoints\Domain\Helper\FileExtension;

class GenerateFileCommand implements GenerateFileCommandInterface
{
    protected array $config;
    protected CsvBuilder $csvBuilder;
    protected XmlBuilder $xmlBuilder;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->csvBuilder = new CsvBuilder;
        $this->xmlBuilder = new XmlBuilder;
    }

    public function execute($data, string $filename)
    {
        foreach ($this->config as $param) {
            switch ($param) {
                case FileExtension::XML:
                    $this->xmlBuilder->build($filename, $data, []);
                    break;
                case FileExtension::CSV:
                    $this->csvBuilder->build($filename, $data, DeliveryPointFactory::getHeaders());
                    break;
            }
        }
    }
}