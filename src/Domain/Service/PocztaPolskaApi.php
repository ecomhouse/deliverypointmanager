<?php

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use ZipArchive;

class PocztaPolskaApi implements SpeditorInterface
{
    const NAME = 'pocztapolska';
    const URL = 'https://placowki.poczta-polska.pl/pliki-owp.php?t=xmlK48S';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getPoints(array $params = []): array
    {
        $result = [];
        $path = '/var/www/html/var/data/';
        $fileName = $path . basename(self::URL);
        file_put_contents($fileName, file_get_contents(self::URL));

        $zip = new ZipArchive;
        if ($zip->open($fileName) === true) {
            $zip->extractTo($path);
            $zip->close();
            $data = simplexml_load_string(file_get_contents($path . $_ENV['POCZTA_POLSKA_FILENAME']));

            foreach ($data as $child) {
                $data = current((array)$child);
                $result[] = DeliveryPointFactory::build((object)$data, self::NAME);
            }
        }
        unlink($fileName);
        unlink($path . $_ENV['POCZTA_POLSKA_FILENAME']);

        return $result;
    }
}