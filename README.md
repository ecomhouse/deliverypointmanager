![methods][img1]

# EcomHouse DeliveryPoints Application

## Description

**EcomHouse DeliveryPoint API - Simple PHP Application without framework. 
The application connects via the API of various speditors and downloads from them data about pickup points to files, e.g. xml, csv.**

## Requirements
- PHP v8.1
- Composer 2

## Installation

1. run script: ./start
2. run script: ./shell
3. run command: composer install
4. you need to create an .env file in the config/ folder. Example in the .env.example file

## Scripts

To run the application you must run a command: php run.php with parameters

Example:

php run.php xml,csv inpost,dhl,orlen,pocztapolska - parameters must be decimals without spaces

php run.php xml inpost - generate only xml files for only inpost speditor

First parameters - files extensions
Second parameters - speditors

Other:

./stop - stop docker containers

## Tests
You need to create an phpunit.xml file in the root project. Example in the phpunit.xml.dist file

run command: ./vendor/bin/phpunit tests

[img1]: logo.svg
