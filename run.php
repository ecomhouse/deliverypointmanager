<?php

require 'vendor/autoload.php';

use EcomHouse\DeliveryPoints\Application\Command\GenerateFileCommand;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config');
$dotenv->load();

echo "Start process\n";
$config['extensions'] = isset($argv[1]) ? explode(",", $argv[1]) : [];
$config['speditors'] = isset($argv[2]) ? explode(",", $argv[2]) : [];
$generateFileCommand = new GenerateFileCommand($config);
$generateFileCommand->execute();

echo "End process\n";
