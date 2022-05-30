<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

interface SpeditorInterace
{
    /**
     * @param array $params
     * @return array
     */
    public function getPoints(array $params = []): array;
}