<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

interface SpeditorInterace
{
    /**
     * @param string $token
     * @param string|null $postCode
     * @return mixed
     */
    public function getPoints(string $token, ?string $postCode = null);
}