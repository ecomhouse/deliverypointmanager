<?php

namespace EcomHouse\DeliveryPoints\Domain\Helper;

use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorUri;
use ZipArchive;

final class ZipHelper
{
    private ZipArchive $zip;

    public function __construct()
    {
        $this->zip = new ZipArchive();
    }

    public function extract($fileName): void
    {
        if ($this->zip->open($fileName) === true) {
            $this->zip->extractTo(ConnectorUri::PATH);
            $this->zip->close();
        }
    }

    public function remove($fileName): void
    {
        unlink($fileName);
    }
}