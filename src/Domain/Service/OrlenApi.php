<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use SoapClient;

class OrlenApi implements SpeditorInterface
{
    const NAME = 'orlen';
    const WSDL_PROD = 'https://api.orlenpaczka.pl/WebServicePwRProd/WebServicePwR.asmx?wsdl';
    const WSDL_SANDBOX = 'https://api-test.orlenpaczka.pl/WebServicePwR/WebServicePwRTest.asmx?WSDL';

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
        $response = $this->client->__soapCall("GiveMeAllRUCHWithFilled", ['parameters' => $this->getParams()]);
        $result = [];
        foreach ($response->GiveMeAllRUCHWithFilledResult->Data->PointPwR as $point) {
            $result[] = DeliveryPointFactory::build($point, self::NAME);
        }

        return $result;
    }

    private function getParams(): array
    {
        return [
            'PartnerID' => $_ENV['ORLEN_PARTNER_ID'],
            'PartnerKey' => $_ENV['ORLEN_PARTNER_KEY']
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