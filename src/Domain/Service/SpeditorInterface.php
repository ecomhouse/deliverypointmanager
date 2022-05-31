<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

interface SpeditorInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function getPoints(array $params = []): array;
}