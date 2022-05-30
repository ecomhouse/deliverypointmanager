<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

use EcomHouse\DeliveryPoints\Domain\DataBuilder\CsvBuilder;
use EcomHouse\DeliveryPoints\Domain\DataBuilder\XmlBuilder;
use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;

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

    public function execute($data, string $filename, $speditor)
    {
        $data = DeliveryPointFactory::build($data, $speditor);

        foreach ($this->config as $param) {
            // @todo: parametry case stworzyć jako const
            switch ($param) {
                case 'xml':
                    $this->xmlBuilder->build($filename, $data, []);
                    break;
                case 'csv':
                    $this->csvBuilder->build($filename, $data, DeliveryPointFactory::getHeaders());
                    break;
            }
        }
    }
}