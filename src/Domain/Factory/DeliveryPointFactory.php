<?php

namespace EcomHouse\DeliveryPoints\Domain\Factory;

class DeliveryPointFactory implements FactoryInterface
{
    public static function build($data): array
    {
        $result['headers'] = [
            'delivery-point-x',
            'delivery-point-y',
            'delivery-point-code',
            'delivery-point-type',
            'delivery-point-address',
            'delivery-point-city',
            'delivery-point-postcode',
            'delivery-point-comment',
        ];

        foreach ($data as $point) {
            $result['data'][] = [
                'delivery-point-x' => $point->getLongitude(),
                'delivery-point-y' => $point->getLatitude(),
                'delivery-point-code' => $point->getCode(),
                'delivery-point-type' => $point->getType(),
                'delivery-point-address' => $point->getAddress(),
                'delivery-point-city' => $point->getCity(),
                'delivery-point-postcode' => $point->getPostCode(),
                'delivery-point-comment' => $point->getComment(),
            ];
        }

        return $result;
    }
}