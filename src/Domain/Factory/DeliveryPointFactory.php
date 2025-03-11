<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Factory;

use EcomHouse\DeliveryPoints\Domain\Helper\WeekDayHelper;
use EcomHouse\DeliveryPoints\Domain\Model\DeliveryPoint;
use EcomHouse\DeliveryPoints\Domain\Service\DhlApi;
use EcomHouse\DeliveryPoints\Domain\Service\DpdApi;
use EcomHouse\DeliveryPoints\Domain\Service\InpostApi;
use EcomHouse\DeliveryPoints\Domain\Service\OrlenApi;
use EcomHouse\DeliveryPoints\Domain\Service\PocztaPolskaApi;

class DeliveryPointFactory implements FactoryInterface
{
    const COLUMN_DELIVERY_POINT_X = 'delivery-point-x';
    const COLUMN_DELIVERY_POINT_Y = 'delivery-point-y';
    const COLUMN_DELIVERY_POINT_NAME = 'delivery-point-name';
    const COLUMN_DELIVERY_POINT_CODE = 'delivery-point-code';
    const COLUMN_DELIVERY_POINT_TYPE = 'delivery-point-type';
    const COLUMN_DELIVERY_POINT_ADDRESS = 'delivery-point-address';
    const COLUMN_DELIVERY_POINT_CITY = 'delivery-point-city';
    const COLUMN_DELIVERY_POINT_POSTCODE = 'delivery-point-postcode';
    const COLUMN_DELIVERY_POINT_HINT = 'delivery-point-hint';

    public static function getHeaders(): array
    {
        return [
            self::COLUMN_DELIVERY_POINT_X,
            self::COLUMN_DELIVERY_POINT_Y,
            self::COLUMN_DELIVERY_POINT_NAME,
            self::COLUMN_DELIVERY_POINT_CODE,
            self::COLUMN_DELIVERY_POINT_TYPE,
            self::COLUMN_DELIVERY_POINT_ADDRESS,
            self::COLUMN_DELIVERY_POINT_CITY,
            self::COLUMN_DELIVERY_POINT_POSTCODE,
            self::COLUMN_DELIVERY_POINT_HINT
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
            DpdApi::NAME => self::buildDpdData($data),
            OrlenApi::NAME => self::buildOrlenData($data),
            PocztaPolskaApi::NAME => self::buildPostOfficeData($data),
            default => null
        };
    }

    private static function buildInpostData($data): DeliveryPoint
    {
        $deliveryPoint = new DeliveryPoint();
        $address = $data->address_details;
        $deliveryPoint->setLatitude((float)$data->location->latitude);
        $deliveryPoint->setLongitude((float)$data->location->longitude);
        $deliveryPoint->setName($data->name);
        $deliveryPoint->setCode($data->name);
        $deliveryPoint->setType(InpostApi::NAME);
        $deliveryPoint->setStreet((string)$address->street);
        $deliveryPoint->setCity($address->city);
        $deliveryPoint->setPostCode($address->post_code);
        $deliveryPoint->setOpeningHours($data->opening_hours ?? '');
        $deliveryPoint->setHint((string)$data->location_description);
        return $deliveryPoint;
    }

    private static function buildDhlData($data): DeliveryPoint
    {
        $deliveryPoint = new DeliveryPoint();
        $address = $data->address;
        $deliveryPoint->setLatitude((float)$data->latitude);
        $deliveryPoint->setLongitude((float)$data->longitude);
        $deliveryPoint->setName($data->name);
        $deliveryPoint->setCode($address->name ?: $data->name);
        $deliveryPoint->setType(DhlApi::NAME);
        $deliveryPoint->setStreet($address->street);
        $deliveryPoint->setCity($address->city);
        $deliveryPoint->setPostCode(substr_replace($address->postcode, "-", 2, 0));
        $deliveryPoint->setOpeningHours(WeekDayHelper::getOpeningHours($data));
        $deliveryPoint->setHint($address->name);
        return $deliveryPoint;
    }

    private static function buildDpdData($data): DeliveryPoint
    {
        $deliveryPoint = new DeliveryPoint();
        $deliveryPoint->setLatitude((float)$data->latitude);
        $deliveryPoint->setLongitude((float)$data->longitude);
        $deliveryPoint->setName($data->name);
        $deliveryPoint->setCode($data->code);
        $deliveryPoint->setType(DpdApi::NAME);
        $deliveryPoint->setStreet($data->street);
        $deliveryPoint->setCity($data->city);
        $deliveryPoint->setPostCode(substr_replace($data->postcode, "-", 2, 0));
        $deliveryPoint->setOpeningHours($data->openingHours);
        $deliveryPoint->setHint($data->hint);

        return $deliveryPoint;
    }

    private static function buildOrlenData($data): DeliveryPoint
    {
        $deliveryPoint = new DeliveryPoint();
        $deliveryPoint->setLatitude((float)$data->Latitude);
        $deliveryPoint->setLongitude((float)$data->Longitude);
        $deliveryPoint->setName($data->DestinationCode);
        $deliveryPoint->setCode($data->DestinationCode);
        $deliveryPoint->setType(OrlenApi::NAME);
        $deliveryPoint->setStreet($data->StreetName);
        $deliveryPoint->setCity($data->City);
        $deliveryPoint->setPostCode($data->ZipCode);
        $deliveryPoint->setOpeningHours($data->OpeningHours ?? '');
        $deliveryPoint->setHint((isset($data->Location)) ? str_replace("\n", "", $data->Location) : '');
        return $deliveryPoint;
    }

    private static function buildPostOfficeData($data): DeliveryPoint
    {
        $deliveryPoint = new DeliveryPoint();
        $deliveryPoint->setLatitude((float)$data->y);
        $deliveryPoint->setLongitude((float)$data->x);
        $deliveryPoint->setName($data->nazwa);
        $deliveryPoint->setCode($data->pni);
        $deliveryPoint->setType(PocztaPolskaApi::NAME);
        $deliveryPoint->setStreet($data->ulica);
        $deliveryPoint->setCity($data->miejscowosc);
        $deliveryPoint->setPostCode($data->kod);
        $deliveryPoint->setOpeningHours($data->opis);
        $deliveryPoint->setHint($data->opis);
        return $deliveryPoint;
    }
}