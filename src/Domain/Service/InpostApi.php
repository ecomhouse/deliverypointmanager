<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use EcomHouse\DeliveryPoints\Domain\Helper\Speditor;
use EcomHouse\DeliveryPoints\Domain\Model\DeliveryPoint;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorInterface;

class InpostApi implements SpeditorInterface
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

    public function getName(): string
    {
        return Speditor::INPOST;
    }

    /**
     * @param array $params
     * @return DeliveryPoint[]
     */
    public function getPoints(array $params = []): array
    {
        $url = $this->baseUri() . 'v1/points';
        $page = $params['page'] ?? 1;
        $url .= '?page=' . $page;
        $perPage = $params['per_page'] ?? $this->getCountPoints();
        $url .= '&per_page=' . $perPage;

        $response = $this->connector->doRequest($url, $this->getParams());
        $points = json_decode($response->getBody());

        $result = [];
        foreach ($points->items as $point) {
            $result[] = DeliveryPointFactory::build($point, Speditor::INPOST);
        }

        return $result;
    }

    public function getCountPoints(): int
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
