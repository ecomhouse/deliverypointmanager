<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

class DhlApi implements SpeditorInterace
{
    private const API_URL = 'https://api-gw.dhlparcel.nl/';

    public function getPoints(string $token, ?int $page = 1, ?int $perPage = 25)
    {
        // TODO: Implement getPoints() method.
    }
}
