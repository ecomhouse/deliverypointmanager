<?php

namespace EcomHouse\DeliveryPoints\Infrastructure\Connector;

class ConnectorUri implements ConnectorInterface
{
    const PATH = 'var/data/';

    public function doRequest(string $uriEndpoint, array $params = [], string $requestMethod = 'GET')
    {
        $fileName = $_ENV['FILE_PATH_DIRECTORY'] . basename($uriEndpoint);
        file_put_contents($fileName, file_get_contents($uriEndpoint));

        return $fileName;
    }
}