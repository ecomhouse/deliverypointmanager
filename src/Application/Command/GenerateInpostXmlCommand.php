<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

use EcomHouse\DeliveryPoints\Domain\DataBuilder\XmlBuilder;
use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorApi;
use GuzzleHttp\Client as GuzzleClient;

class GenerateInpostXmlCommand implements GenerateXmlCommandInterface
{
    protected InpostApi $inpostApi;

    protected XmlBuilder $xmlBuilder;

    public function __construct()
    {
        $this->inpostApi = new InpostApi(new ConnectorApi(new GuzzleClient));
        $this->xmlBuilder = new XmlBuilder;
    }

    public function execute(string $token, string $filename)
    {
        $response = $this->inpostApi->getPoints($token, 1, $this->getCount($token));
        $points = json_decode($response->getBody());
        $data = [];
        foreach ($points->items as $point) {
            $address = $point->address_details;
            $comment = $point->location_description;
            if (isset($comment)) {
                $comment = str_replace('&', '&amp;', $point->location_description);
            }

            $data[] = [
                'delivery-point-x' => $point->location->longitude,
                'delivery-point-y' => $point->location->latitude,
                'delivery-point-code' => $point->name,
                'delivery-point-type' => reset($point->type),
                'delivery-point-address' => $address->street,
                'delivery-point-city' => $address->city,
                'delivery-point-postcode' => $address->post_code,
                'delivery-point-comment' => $comment,
            ];
        }

        $this->xmlBuilder->build($filename, $data, []);
    }

    private function getCount(string $token)
    {
        $response = $this->inpostApi->getPoints($token, 1, 1);
        $data = json_decode($response->getBody());
        return $data->count;
    }
}