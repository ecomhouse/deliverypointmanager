<?php

require 'vendor/autoload.php';

use EcomHouse\DeliveryPoints\Application\Command\GenerateInpostXmlCommand;
use EcomHouse\DeliveryPoints\Application\Command\GenerateInpostCsvCommand;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config');
$dotenv->load();

echo "Start process\n";
$generateInpostXmlCommand = new GenerateInpostXmlCommand;
$generateInpostXmlCommand->execute($_ENV['INPOST_API_TOKEN'], $_ENV['INPOST_DELIVERY_POINTS_FILENAME']);

$generateInpostCsvCommand = new GenerateInpostCsvCommand;
$generateInpostCsvCommand->execute($_ENV['INPOST_API_TOKEN'], $_ENV['INPOST_DELIVERY_POINTS_FILENAME']);

echo "End process\n";
