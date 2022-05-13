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

    public function getPoints(string $token, ?string $postCode = null)
    {
        $url = 'v1/points';
        if ($postCode) {
            $url .= '?relative_post_code=' . $postCode;
        }


        return $this->get([self::API_URL. $url], $this->getParams($token));
    }

    /**
     * @param $token
     * @return array
     */
    private function getParams($token): array
    {
        return [
            'headers' => [ 'Authorization' => 'Bearer ' . $token]
        ];
    }

}
