<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

use SoapClient;

class PaczkaWRuchuApi implements SpeditorInterace
{
    const WSDL_PROD = 'https://api.paczkawruchu.pl/WebServicePwRProd/WebServicePwR.asmx?wsdl';
    const WSDL_TEST = 'https://api-test.paczkawruchu.pl/WebServicePwR/WebServicePwRTest.asmx?wsdl';

    protected array $config;

    protected SoapClient $client;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->client = new SoapClient($this->baseUri());
    }

    public function getPoints(array $params = [])
    {
        $response = $this->client->__soapCall("GiveMeAllRUCHLocation", ['parameters' => $this->getParams()]);
        return $response->GiveMeAllRUCHLocationResult;
    }

    private function getParams(): array
    {
        return [
            'partnerId' => $this->config['ORLEN_PARTNER_ID'],
            'partnerKey' => $this->config['ORLEN_PARTNER_KEY']
        ];
    }

    private function baseUri(): string
    {
        if ($this->config['sandbox'] ?? false) {
            return self::WSDL_TEST;
        }
        return self::WSDL_PROD;
    }

}