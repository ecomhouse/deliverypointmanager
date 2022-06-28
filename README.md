![methods][img1]

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
4. you need to create an .env file in the config/ folder. Example in the .env.example file

Installation is super-easy via [Composer](https://getcomposer.org/):

```bash
$ composer require ecomhouse/deliverypoints
```

or add it by hand to your `composer.json` file.

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

When a new developer clones your codebase, they will have an additional
one-time step to manually copy the `.env.example` file to `.env` and fill-in
their own values (or get any sensitive values from a project co-worker).

Example:
```shell
SANDBOX=true
INPOST_API_TOKEN="token"
```

Sandbox=false for production environments.

### Scripts

To run the application you must run a command: php run.php with parameters.

Example:
```php
php run.php xml,csv inpost,dhl,orlen,pocztapolska  // parameters must be decimals without spaces

php run.php xml inpost // generate only xml files for only inpost speditor
```
First parameters - files extensions
Second parameters - speditors

Other:

./stop - stop docker containers

## Unit tests
You need to create an phpunit.xml file in the root project. Example in the phpunit.xml.dist file

run command: 
```php
./vendor/bin/phpunit tests
```

## Security

If you discover a security vulnerability within this package, please send an email to help@ecom.house . All security vulnerabilities will be promptly addressed. You may view our full security policy [here](./.github/SECURITY.md).

## License

EcomHouse DeliveryPoints is licensed under [The BSD 3-Clause License](LICENSE).

[img1]: .github/logo.svg
