<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

use SoapClient;

class DhlApi implements SpeditorInterace
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

    public function getPoints(?int $page = 1, ?int $perPage = 25)
    {
        $params = $this->getParams();
        $params['structure'] = [
            'country' => 'PL',
            'postcode' => '00110',
            'city' => 'Warszawa',
            'radius' => 500,
        ];

        return $this->client->__soapCall("getNearestServicepoints", ['parameters' => $params]);
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
