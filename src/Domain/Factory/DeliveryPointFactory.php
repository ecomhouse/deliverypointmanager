<?php

namespace EcomHouse\DeliveryPoints\Domain\Factory;

use EcomHouse\DeliveryPoints\Domain\Model\DeliveryPoint;
use EcomHouse\DeliveryPoints\Domain\Service\DhlApi;
use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;
use EcomHouse\DeliveryPoints\Domain\Service\OrlenApi;

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

    /**
     * @param $data
     * @param string $speditor
     * @return DeliveryPoint|null
     */
    public static function build($data, string $speditor): ?DeliveryPoint
    {
        return match ($speditor) {
            InpostApi::NAME => self::buildInpostData($data),
            DhlApi::NAME => self::buildDhlData($data),
            OrlenApi::NAME => self::buildOrlenData($data),
            default => null
        };
    }

    private static function buildInpostData($data): DeliveryPoint
    {
        $deliveryPoint = new DeliveryPoint();
        $address = $data->address_details;
        $deliveryPoint->setLongitude((float)$data->location->longitude);
        $deliveryPoint->setLatitude((float)$data->location->latitude);
        $deliveryPoint->setName($data->name);
        $deliveryPoint->setType(reset($data->type));
        $deliveryPoint->setStreet((string)$address->street);
        $deliveryPoint->setCity($address->city);
        $deliveryPoint->setPostCode($address->post_code);
        $deliveryPoint->setComment((string)$data->location_description);
        return $deliveryPoint;
    }

    private static function buildDhlData($data): DeliveryPoint
    {
        $deliveryPoint = new DeliveryPoint();
        $address = $data->address;
        $deliveryPoint->setLongitude($data->longitude);
        $deliveryPoint->setLatitude($data->latitude);
        $deliveryPoint->setName($data->name);
        $deliveryPoint->setType($data->type);
        $deliveryPoint->setStreet($address->street);
        $deliveryPoint->setCity($address->city);
        $deliveryPoint->setPostCode($address->postcode);
        $deliveryPoint->setComment($address->name);
        return $deliveryPoint;
    }

    private static function buildOrlenData($data): DeliveryPoint
    {
        $deliveryPoint = new DeliveryPoint();
        $deliveryPoint->setLongitude($data->Longitude);
        $deliveryPoint->setLatitude($data->Latitude);
        $deliveryPoint->setName($data->DestinationCode);
        $deliveryPoint->setType($data->PointType);
        $deliveryPoint->setStreet($data->StreetName);
        $deliveryPoint->setCity($data->City);
        $deliveryPoint->setPostCode($data->ZipCode);
        $deliveryPoint->setComment($data->Location ?? '');
        return $deliveryPoint;
    }

}