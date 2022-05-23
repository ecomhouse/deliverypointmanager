<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

interface SpeditorInterace
{
    /**
     * @param int|null $page
     * @param int|null $perPage
     * @return mixed
     */
    public function getPoints(?int $page = 1, ?int $perPage = 25);
}