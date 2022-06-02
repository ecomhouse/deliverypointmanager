<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use EcomHouse\DeliveryPoints\Domain\Helper\Speditor;
use SoapClient;

class DhlApi implements SpeditorInterface
{
    const WSDL_PROD = 'https://dhl24.com.pl/webapi2';
    const WSDL_SANDBOX = 'https://sandbox.dhl24.com.pl/webapi2';

    protected array $config;

    protected SoapClient $client;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->client = new SoapClient($this->baseUri());
    }

    public function getName(): string
    {
        return Speditor::DHL;
    }

    public function getPoints(array $params = []): array
    {
        $parameters = $this->getParams();
        $parameters['structure'] = [
            'country' => $this->config['country'],
            'postcode' => $this->config['postcode'],
            'city' => $this->config['city'],
            'radius' => $this->config['radius'],
        ];
        $response = $this->client->__soapCall("getNearestServicepoints", ['parameters' => $parameters]);

        $result = [];
        foreach ($response->getNearestServicepointsResult->points->item as $point) {
            $result[] = DeliveryPointFactory::build($point, Speditor::DHL);
        }

        return $result;
    }

    private function getParams(): array
    {
        return [
            'authData' => [
                'username' => $this->config['username'], 'password' => $this->config['password']
            ]
        ];
    }

    private function baseUri(): string
    {
        if ($this->config['sandbox'] ?? false) {
            return self::WSDL_SANDBOX;
        }
        return self::WSDL_PROD;
    }

}
