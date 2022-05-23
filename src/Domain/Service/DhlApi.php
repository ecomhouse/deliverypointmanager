<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorInterface;

class DhlApi implements SpeditorInterace
{
    private const API_URL = 'https://api-gw.dhlparcel.nl/';

    private ConnectorInterface $connector;

    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    public function getPoints(?int $page = 1, ?int $perPage = 25)
    {
        // TODO: Implement getPoints() method.
    }
}
