<?php

namespace EcomHouse\DeliveryPoints\Domain\Factory;

class DeliveryPointFactory implements FactoryInterface
{
    const COLUMN_DELIVERY_POINT_X = 'delivery-point-x';
    const COLUMN_DELIVERY_POINT_Y = 'delivery-point-y';
    const COLUMN_DELIVERY_POINT_CODE = 'delivery-point-code';
    const COLUMN_DELIVERY_POINT_TYPE = 'delivery-point-type';
    const COLUMN_DELIVERY_POINT_ADDRESS = 'delivery-point-address';
    const COLUMN_DELIVERY_POINT_CITY = 'delivery-point-city';
    const COLUMN_DELIVERY_POINT_POSTCODE = 'delivery-point-postcode';
    const COLUMN_DELIVERY_POINT_COMMENT = 'delivery-point-comment';

    public static function getHeaders(): array
    {
        return [
            self::COLUMN_DELIVERY_POINT_X,
            self::COLUMN_DELIVERY_POINT_Y,
            self::COLUMN_DELIVERY_POINT_CODE,
            self::COLUMN_DELIVERY_POINT_TYPE,
            self::COLUMN_DELIVERY_POINT_ADDRESS,
            self::COLUMN_DELIVERY_POINT_CITY,
            self::COLUMN_DELIVERY_POINT_POSTCODE,
            self::COLUMN_DELIVERY_POINT_COMMENT
        ];
    }

    public static function build($data): array
    {
        $result = [];
        foreach ($data as $point) {
            $result[] = [
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

    // @todo:prywatne metody z konkretnymi danymi

}