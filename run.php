<?php

require 'vendor/autoload.php';

use EcomHouse\DeliveryPoints\Application\Command\GenerateFileCommand;
use EcomHouse\DeliveryPoints\Domain\Model\Speditor;
use EcomHouse\DeliveryPoints\Domain\Service\DhlApi;
use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorApi;
use GuzzleHttp\Client as GuzzleClient;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config');
$dotenv->load();

echo "Start process\n";
$generateFileCommand = new GenerateFileCommand;

$inpostApi = new InpostApi(new ConnectorApi(new GuzzleClient), ['sandbox' => $_ENV['SANDBOX'], 'token' => $_ENV['INPOST_API_TOKEN']]);
$points = $inpostApi->getPoints(['page' => 1, 'per_page' => $inpostApi->getCountPoints()]);

$generateFileCommand->execute($points, $_ENV['INPOST_DELIVERY_POINTS_FILENAME'], Speditor::INPOST);

$dhlApi = new DhlApi(['sandbox' => $_ENV['SANDBOX'], 'username' => $_ENV['DHL_API_USER'], 'password' => $_ENV['DHL_API_PASSWORD']]);
$points = $dhlApi->getPoints([
    'country' => 'PL',
    'postcode' => '00110',
    'city' => 'Warszawa',
    'radius' => 500,
]);
$generateFileCommand->execute($points->points->item, $_ENV['DHL_DELIVERY_POINTS_FILENAME'], Speditor::DHL);

echo "End process\n";
