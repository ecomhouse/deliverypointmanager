<?php

namespace EcomHouse\DeliveryPoints\Infrastructure\Connector;

class ConnectorUri implements ConnectorInterface
{
    const PATH = '/var/www/html/var/data/';

    public function doRequest(string $uriEndpoint, array $params = [], string $requestMethod = 'GET')
    {
        $fileName = self::PATH . basename($uriEndpoint);
        file_put_contents($fileName, file_get_contents($uriEndpoint));

        return $fileName;
    }
}