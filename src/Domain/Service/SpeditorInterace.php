<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

interface SpeditorInterace
{
    /**
     * @param array $params
     * @return mixed
     */
    public function getPoints(array $params = []);
}