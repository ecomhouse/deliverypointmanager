![methods][img1]

## Version
[![version](https://img.shields.io/badge/version-1.0.0-green.svg)](https://semver.org)
![build](https://img.shields.io/badge/build-passing-green?labelColor=gray&style=flat)


# EcomHouse DeliveryPoints Application

## Description

**EcomHouse DeliveryPoint API - Simple PHP Application without framework and GUI. 
The command application connects via the API of various speditors and downloads from them data about pickup points to files, e.g. xml, csv.**

## Requirements
- PHP v8.1
- Composer 2

## Installation

Installation application on docker:

1. run script: ./start
2. run script: ./shell
3. run command: composer install
4. create an .env file in the config/ folder. Example in the .env.example file

Install module via [Composer](https://getcomposer.org/):

```bash
$ composer require ecomhouse/deliverypoints
```

or add it manually to `composer.json` file

## Usage

The instantiator is able to create new instances of any class without using the constructor or any API of the class
itself:

```php
$config['extensions'] = ['csv', 'xml'];
$config['speditors'] = ['dhl', 'inpost', 'orlen', 'pocztapolska'];

$generateFileCommand = new EcomHouse\DeliveryPoints\Application\Command\GenerateFileCommand($config);
$generateFileCommand->execute();
```

## Usage Notes .ENV

When installing the application, the new developers will have to manually copy 
the `.env.example` file to the `.env` and fill in with their own values 
(the alternative way is to operate on sensitive data received from the code author).

Example:
```shell
SANDBOX=true
INPOST_API_TOKEN="token"
```

Sandbox=false for production environments.

### Scripts

Run an application from command:php line run.php with parameters...

Example:
```php
php run.php xml,csv inpost,dhl,dpd,orlen,pocztapolska  // parameters must be decimals without spaces

php run.php xml inpost // generate only xml files for only inpost speditor
```
First parameters - files extensions
Second parameters - speditors

Other:

./stop - stop docker containers

## Unit tests
Run Unit Tests by creating a phpunit.xml file in the root project. Example in the phpunit.xml.dist file.

run command: 
```php
./vendor/bin/phpunit tests
```

## Security

If you discover a security vulnerability within this package, please send an email to help@ecom.house . All security vulnerabilities will be promptly addressed. You may view our full security policy [here](./.github/SECURITY.md).

## License

EcomHouse DeliveryPoints is licensed under [The BSD 3-Clause License](LICENSE).

[img1]: .github/logo.svg
