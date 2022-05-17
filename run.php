<?php

require 'vendor/autoload.php';

use EcomHouse\DeliveryPoints\Application\Command\GenerateInpostXmlCommand;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config');
$dotenv->load();

echo "Start process\n";
$generateInpostXmlCommand = new GenerateInpostXmlCommand;
$generateInpostXmlCommand->execute($_ENV['INPOST_API_TOKEN'], $_ENV['INPOST_DELIVERY_POINTS_FILENAME']);
echo "End process\n";
