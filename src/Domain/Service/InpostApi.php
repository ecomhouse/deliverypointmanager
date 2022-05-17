<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorInterface;

class InpostApi implements SpeditorInterace
{
    private const API_URL = 'https://sandbox-api-gateway-pl.easypack24.net/';

    private ConnectorInterface $connector;

    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    public function getPoints(string $token, ?int $page = 1, ?int $perPage = 25)
    {
        $url = self::API_URL.'v1/points';
        if ($page) {
            $url .= '?page=' . $page;
        }
        if ($perPage) {
            $url .= '&per_page=' . $perPage;
        }
        return $this->connector->doRequest($url, $this->getParams($token));
    }

    /**
     * @param string $token
     * @return array
     */
    private function getParams(string $token): array
    {
        return [
            'headers' => [ 'Authorization' => 'Bearer ' . $token]
        ];
    }

}
