<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

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

    public function getPoints(string $token, ?int $page = 1, ?int $perPage = 25)
    {
        $url = $this->baseUri() . 'v1/points';
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
            'headers' => ['Authorization' => 'Bearer ' . $token]
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
