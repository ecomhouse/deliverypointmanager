<?php
declare(strict_types=1);

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
        if (filter_var($_ENV['SANDBOX'], FILTER_VALIDATE_BOOLEAN)) {
            $response = $this->client->__soapCall("GiveMeAllRUCHWithFilled", ['parameters' => $this->getParams()]);
        } else {
            $response = $this->getPointsBySoapRequest();
        }
        $result = [];
        foreach ($response->GiveMeAllRUCHWithFilledResult->Data->PointPwR as $point) {
            $result[] = DeliveryPointFactory::build($point, self::NAME);
        }

        return $result;
    }

    private function getPointsBySoapRequest()
    {
        $request = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:web="https://91.242.220.103/WebServicePwR">
           <soap:Header/>
           <soap:Body>
              <web:GiveMeAllRUCHWithFilled>
                 <web:PartnerID>' . $_ENV['ORLEN_PARTNER_ID'] . '</web:PartnerID>
                 <web:PartnerKey>' . $_ENV['ORLEN_PARTNER_KEY'] . '</web:PartnerKey>
              </web:GiveMeAllRUCHWithFilled>
           </soap:Body>
        </soap:Envelope>';

        $response = $this->client->__doRequest($request, self::WSDL_PROD, "run", SOAP_1_2);
        $result = simplexml_load_string(str_replace("soap:", "soap", $response));
        $object = json_decode(json_encode($result));

        return $object->soapBody->GiveMeAllRUCHWithFilledResponse;
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
        if (filter_var($_ENV['SANDBOX'], FILTER_VALIDATE_BOOLEAN)) {
            return self::WSDL_SANDBOX;
        }
        return self::WSDL_PROD;
    }
}