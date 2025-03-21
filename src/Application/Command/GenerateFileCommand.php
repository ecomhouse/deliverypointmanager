<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Application\Command;

use EcomHouse\DeliveryPoints\Domain\DataBuilder\CsvBuilder;
use EcomHouse\DeliveryPoints\Domain\DataBuilder\XmlBuilder;
use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use EcomHouse\DeliveryPoints\Domain\Service\DhlApi;
use EcomHouse\DeliveryPoints\Domain\Service\DpdApi;
use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;
use EcomHouse\DeliveryPoints\Domain\Service\OrlenApi;
use EcomHouse\DeliveryPoints\Domain\Service\PocztaPolskaApi;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorApi;
use EcomHouse\DeliveryPoints\Infrastructure\Logger\Logger;
use GuzzleHttp\Client as GuzzleClient;

class GenerateFileCommand implements GenerateFileCommandInterface
{
    private array $dataBuilder = [];
    private array $speditors = [];
    private Logger $logger;

    public function __construct(array $config = [])
    {
        $this->logger = new Logger('default');
        foreach ($config['speditors'] as $param) {
            $this->speditors[] = match ($param) {
                InpostApi::NAME => new InpostApi(new ConnectorApi(new GuzzleClient)),
                DhlApi::NAME => new DhlApi(),
                DpdApi::NAME => new DpdApi(),
                OrlenApi::NAME => new OrlenApi(),
                PocztaPolskaApi::NAME => new PocztaPolskaApi()
            };
        }

        foreach ($config['extensions'] as $param) {
            $this->dataBuilder[] = match ($param) {
                XmlBuilder::FILE_EXTENSION => new XmlBuilder,
                CsvBuilder::FILE_EXTENSION => new CsvBuilder
            };
        }
    }

    public function execute()
    {
        try {
            foreach ($this->speditors as $speditor) {
                $data = $speditor->getPoints();
                foreach ($this->dataBuilder as $dataBuilder) {
                    $dataBuilder->build($speditor->getName(), $data, DeliveryPointFactory::getHeaders());
                    $this->logger->info('Import data delivery points', ['speditor' => $speditor->getName(), 'file' => $dataBuilder->getFileExtension(), 'count' => count($data)]);
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage(), $e->getTrace());
        }
    }
}