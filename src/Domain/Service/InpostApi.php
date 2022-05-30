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

    public function getPoints(array $params = [])
    {
        $url = $this->baseUri() . 'v1/points';
        $url .= '?page=' . $params['page'] ?? 1;
        $url .= '&per_page=' . $params['per_page'] ?? 25;

        $response = $this->connector->doRequest($url, $this->getParams());
        $points = json_decode($response->getBody());
        return $points->items;
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
