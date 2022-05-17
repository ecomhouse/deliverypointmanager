<?php

namespace EcomHouse\DeliveryPoints\Application\Command;

use EcomHouse\DeliveryPoints\Domain\DataBuilder\CsvBuilder;
use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorApi;
use GuzzleHttp\Client as GuzzleClient;

class GenerateInpostCsvCommand implements GenerateCsvCommandInterface
{
    protected InpostApi $inpostApi;

    protected CsvBuilder $csvBuilder;

    public function __construct()
    {
        $this->inpostApi = new InpostApi(new ConnectorApi(new GuzzleClient));
        $this->csvBuilder = new CsvBuilder;
    }

    public function execute(string $token, string $filename)
    {
        $response = $this->inpostApi->getPoints($token, 1, $this->getCount($token));
        $points = json_decode($response->getBody());
        $data = [];
        foreach ($points->items as $point) {
            $address = $point->address_details;
            $data[] = [
                $point->location->longitude,
                $point->location->latitude,
                $point->name,
                reset($point->type),
                $address->street,
                $address->city,
                $address->post_code,
                $point->location_description ?? 'dupa',
            ];
        }
        $headers = [
            'delivery-point-x',
            'delivery-point-y',
            'delivery-point-code',
            'delivery-point-type',
            'delivery-point-address',
            'delivery-point-city',
            'delivery-point-postcode',
            'delivery-point-comment',
        ];

        $this->csvBuilder->build($filename, $data, $headers);
    }

    private function getCount(string $token)
    {
        $response = $this->inpostApi->getPoints($token, 1, 1);
        $data = json_decode($response->getBody());
        return $data->count;
    }
}