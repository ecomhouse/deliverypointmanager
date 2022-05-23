<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Model\DeliveryPoint;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorInterface;

class InpostApi implements SpeditorInterace
{
    const URI_PRODUCTION = 'https://api.inpost.pl/';
    const URI_SANDBOX = 'https://sandbox-api-gateway-pl.easypack24.net/';

    private ConnectorInterface $connector;

    protected array $config;

    public function __construct(ConnectorInterface $connector, array $config = [])
    {
        $this->connector = $connector;
        $this->config = $config;
    }

    public function getPoints(?int $page = 1, ?int $perPage = 25)
    {
        $url = $this->baseUri() . 'v1/points';
        if ($page) {
            $url .= '?page=' . $page;
        }
        if ($perPage) {
            $url .= '&per_page=' . $perPage;
        }

        $response = $this->connector->doRequest($url, $this->getParams());
        $points = json_decode($response->getBody());
        $data = [];
        foreach ($points->items as $point) {
            $address = $point->address_details;
            $deliveryPoint = new DeliveryPoint();
            $deliveryPoint->setLongitude((float)$point->location->longitude);
            $deliveryPoint->setLatitude((float)$point->location->latitude);
            $deliveryPoint->setCode($point->name);
            $deliveryPoint->setType(reset($point->type));
            $deliveryPoint->setAddress((string)$address->street);
            $deliveryPoint->setCity($address->city);
            $deliveryPoint->setPostCode($address->post_code);
            $deliveryPoint->setComment((string)$point->location_description);
            $data[] = $deliveryPoint;
        }

        return $data;
    }

    public function getCountPoints()
    {
        $url = $this->baseUri() . 'v1/points?page=1&per_page=1';
        $response = $this->connector->doRequest($url, $this->getParams());
        $data = json_decode($response->getBody());
        return $data->count;
    }

    /**
     * @return array
     */
    private function getParams(): array
    {
        return [
            'headers' => ['Authorization' => 'Bearer ' . $this->config['token']]
        ];
    }

    private function baseUri(): string
    {
        if ($this->config['sandbox'] ?? false) {
            return self::URI_SANDBOX;
        }
        return self::URI_PRODUCTION;
    }

}
