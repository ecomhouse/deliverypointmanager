<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use EcomHouse\DeliveryPoints\Domain\Model\DeliveryPoint;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorInterface;

class InpostApi implements SpeditorInterface
{
    const NAME = 'inpost';
    const URI_PRODUCTION = 'https://api.inpost.pl/';
    const URI_SANDBOX = 'https://sandbox-api-gateway-pl.easypack24.net/';

    public function __construct(
        private ConnectorInterface $connector
    ) {}

    public function getName(): string
    {
        return self::NAME;
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
        $url .= '&status=Operating';

        $response = $this->connector->doRequest($url, $this->getParams());
        $points = json_decode((string)$response->getBody());

        $result = [];
        foreach ($points->items as $point) {
            $result[] = DeliveryPointFactory::build($point, self::NAME);
        }

        return $result;
    }

    public function getCountPoints(): int
    {
        $url = $this->baseUri() . 'v1/points?page=1&per_page=1';
        $response = $this->connector->doRequest($url, $this->getParams());
        $data = json_decode((string)$response->getBody());
        return $data->count;
    }

    /**
     * @return array
     */
    private function getParams(): array
    {
        return [
            'headers' => ['Authorization' => 'Bearer ' . $_ENV['INPOST_API_TOKEN']]
        ];
    }

    private function baseUri(): string
    {
        if (filter_var($_ENV['SANDBOX'], FILTER_VALIDATE_BOOLEAN)) {
            return self::URI_SANDBOX;
        }
        return self::URI_PRODUCTION;
    }

}
