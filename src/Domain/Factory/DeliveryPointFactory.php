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

    public static function build($data, string $speditor): array
    {
        $result = [];
        switch ($speditor) {
            case 'inpost':
                static::getInpostData($data, $result);
                break;
            case 'dhl':
                static::getDhlData($data, $result);
                break;
            case 'postoffice':
                break;
        }

        return $result;
    }

    private static function getInpostData($data, &$result)
    {
        foreach ($data as $point) {
            $address = $point->address_details;
            $result[] = [
                'delivery-point-x' => (float)$point->location->longitude,
                'delivery-point-y' => (float)$point->location->latitude,
                'delivery-point-name' => $point->name,
                'delivery-point-type' => reset($point->type),
                'delivery-point-address' => $address->street,
                'delivery-point-city' => $address->city,
                'delivery-point-postcode' => $address->post_code,
                'delivery-point-comment' => (string)$point->location_description,
            ];
        }
    }

    private static function getDhlData($data, &$result)
    {
        foreach ($data as $point) {
            $address = $point->address;
            $result[] = [
                'delivery-point-x' => $point->longitude,
                'delivery-point-y' => $point->latitude,
                'delivery-point-name' => $point->name,
                'delivery-point-type' => $point->type,
                'delivery-point-address' => $address->street,
                'delivery-point-city' => $address->city,
                'delivery-point-postcode' => $address->postcode,
                'delivery-point-comment' => $address->name,
            ];
        }
    }

}