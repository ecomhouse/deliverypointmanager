<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Helper;

final class WeekDayHelper
{
    const WEEKDAYS = [
        'PN' => 'mon',
        'WT' => 'tue',
        'SR' => 'wed',
        'CZ' => 'thu',
        'PI' => 'fri',
        'SO' => 'sat',
        'NI' => 'sun'
    ];

    public static function getOpeningHours($data): string
    {
        $openingHours = '';
        foreach (self::WEEKDAYS as $key => $value) {
            $openingHours .= $key . '.: ' . $data->{$value . 'Open'} . '-' . $data->{$value . 'Close'} . ' ';
        }
        return trim($openingHours);
    }

}