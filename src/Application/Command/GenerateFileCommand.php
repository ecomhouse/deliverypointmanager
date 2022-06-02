<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

use EcomHouse\DeliveryPoints\Domain\DataBuilder\CsvBuilder;
use EcomHouse\DeliveryPoints\Domain\DataBuilder\XmlBuilder;
use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use EcomHouse\DeliveryPoints\Domain\Helper\FileExtension;
use EcomHouse\DeliveryPoints\Domain\Service\DhlApi;
use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorApi;
use GuzzleHttp\Client as GuzzleClient;

class GenerateFileCommand implements GenerateFileCommandInterface
{
    private array $dataBuilder = [];
    private array $speditors = [];

    public function __construct(array $config = [])
    {
        foreach ($config['speditors'] as $param) {
            $this->speditors[] = match ($param) {
                InpostApi::NAME => new InpostApi(new ConnectorApi(new GuzzleClient), ['sandbox' => $_ENV['SANDBOX'], 'token' => $_ENV['INPOST_API_TOKEN']]),
                DhlApi::NAME => new DhlApi([
                    'sandbox' => $_ENV['SANDBOX'],
                    'username' => $_ENV['DHL_API_USER'],
                    'password' => $_ENV['DHL_API_PASSWORD'],
                    'country' => $_ENV['DHL_COUNTRY'],
                    'postcode' => $_ENV['DHL_POSTCODE'],
                    'city' => $_ENV['DHL_CITY'],
                    'radius' => $_ENV['DHL_RADIUS']
                ])
            };
        }

        foreach ($config['extensions'] as $param) {
            $this->dataBuilder[] = match ($param) {
                FileExtension::XML => new XmlBuilder,
                FileExtension::CSV => new CsvBuilder
            };
        }
    }

    public function execute()
    {
        foreach ($this->speditors as $speditor) {
            $data = $speditor->getPoints();
            foreach ($this->dataBuilder as $dataBuilder) {
                $dataBuilder->build($speditor->getName(), $data, DeliveryPointFactory::getHeaders());
            }
        }
    }
}