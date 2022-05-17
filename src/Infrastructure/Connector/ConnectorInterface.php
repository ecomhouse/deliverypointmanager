<?php

namespace EcomHouse\DeliveryPoints\Infrastructure\Connector;

interface ConnectorInterface
{
    public function doRequest(string $uriEndpoint, array $params = [], string $requestMethod = 'GET');
}