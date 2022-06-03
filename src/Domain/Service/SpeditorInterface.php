<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

interface SpeditorInterface
{
    public function getName(): string;

    /**
     * @param array $params
     * @return array
     */
    public function getPoints(array $params = []): array;
}