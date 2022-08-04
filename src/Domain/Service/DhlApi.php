<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use SoapClient;

class DhlApi implements SpeditorInterface
{
    const NAME = 'dhl';
    const WSDL_PROD = 'https://dhl24.com.pl/webapi2';
    const WSDL_SANDBOX = 'https://sandbox.dhl24.com.pl/webapi2';

    protected SoapClient $client;

    public function __construct()
    {
        $this->client = new SoapClient($this->baseUri());
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getPoints(array $params = []): array
    {
        $parameters = $this->getParams();
        $parameters['structure'] = [
            'country' => $_ENV['DHL_COUNTRY'],
            'postcode' => $_ENV['DHL_POSTCODE'],
            'city' => $_ENV['DHL_CITY'],
            'radius' => $_ENV['DHL_RADIUS'],
        ];
        $response = $this->client->__soapCall("getNearestServicepoints", ['parameters' => $parameters]);

        $result = [];
        foreach ($response->getNearestServicepointsResult->points->item as $point) {
            $result[] = DeliveryPointFactory::build($point, self::NAME);
        }

        return $result;
    }

    private function getParams(): array
    {
        return [
            'authData' => [
                'username' => $_ENV['DHL_API_USER'], 'password' => $_ENV['DHL_API_PASSWORD']
            ]
        ];
    }

    private function baseUri(): string
    {
        if ($_ENV['SANDBOX'] ?? false) {
            return self::WSDL_SANDBOX;
        }
        return self::WSDL_PROD;
    }

}
