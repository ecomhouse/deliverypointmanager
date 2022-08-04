<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Service;

use EcomHouse\DeliveryPoints\Domain\Factory\DeliveryPointFactory;
use EcomHouse\DeliveryPoints\Domain\Helper\ZipHelper;
use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorUri;

class PocztaPolskaApi implements SpeditorInterface
{
    const NAME = 'pocztapolska';
    const URL = 'https://placowki.poczta-polska.pl/pliki-owp.php?t=xmlK48S';

    private ConnectorUri $connectorUri;
    private ZipHelper $zipHelper;

    public function __construct()
    {
        $this->connectorUri = new ConnectorUri;
        $this->zipHelper = new ZipHelper;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getPoints(array $params = []): array
    {
        $filenameZip = $this->connectorUri->doRequest(self::URL);
        $this->zipHelper->extract($filenameZip);
        $filename = ConnectorUri::PATH . $_ENV['POCZTA_POLSKA_FILENAME'];
        $result = [];
        $data = simplexml_load_string(file_get_contents($filename));
        foreach ($data as $child) {
            $data = current((array)$child);
            $result[] = DeliveryPointFactory::build((object)$data, self::NAME);
        }

        $this->zipHelper->remove($filename);
        $this->zipHelper->remove($filenameZip);

        return $result;
    }
}