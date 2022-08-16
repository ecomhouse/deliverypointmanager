<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use EcomHouse\DeliveryPoints\Domain\Helper\SftpHelper;
use stdClass;

class DpdApi implements SpeditorInterface
{
    const NAME = 'dpd';
    const HOST = 'gryf.dpd.com.pl';
    const COUNTRY_PL = 'PL';
    const STATUS_ACTIVE = 'Aktywny';
    const SERVICE_PHRASE = 'Odbiór w punkcie';

    private SftpHelper $sftpHelper;

    public function __construct()
    {
        $this->sftpHelper = new SftpHelper(self::HOST, $_ENV['DPD_SFTP_USERNAME'], $_ENV['DPD_SFTP_PASSWORD'], $_ENV['DPD_REMOTE_DIR']);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getPoints(array $params = []): array
    {
        $file = $this->sftpHelper->downloadFile();
        $data = explode("\n", file_get_contents($file));
        unset($data[0]);
        $result = [];
        foreach ($data as $value) {
            list($idPudo, $postcode, $department, $street, $numberFlat, $numberLocal, $city, $dateOpen, $openingHours, $status,
                $services, $longitude, $latitude, $hint) = explode(";", str_replace('"', "", $value));

            if (str_starts_with($idPudo, self::COUNTRY_PL) && $status === self::STATUS_ACTIVE
                && strpos($services, self::SERVICE_PHRASE)) {
                $pointObj = new stdClass;
                $pointObj->code = $idPudo;
                $pointObj->name = $department . " " . $idPudo;
                $pointObj->postcode = $postcode;
                $pointObj->longitude = $longitude;
                $pointObj->latitude = $latitude;
                $pointObj->street = $street;
                $pointObj->city = $city;
                $pointObj->openingHours = $openingHours;
                $pointObj->hint = trim($hint);
                $result[] = DeliveryPointFactory::build($pointObj, self::NAME);
            }
        }

        unlink($file);

        return $result;
    }
}