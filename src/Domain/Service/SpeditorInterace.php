<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

interface SpeditorInterace
{
    /**
     * @param string $token
     * @param int|null $page
     * @param int|null $perPage
     * @return mixed
     */
    public function getPoints(string $token, ?int $page = 1, ?int $perPage = 25);
}