<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Helper;

use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorUri;
use Exception;
use ZipArchive;

final class FileSystemHelper
{
    private ZipArchive $zip;

    public function __construct()
    {
        $this->zip = new ZipArchive();
    }

    /**
     * @throws Exception
     */
    public function getFileDirectory(): string
    {
        $directory = $_ENV['FILE_PATH_DIRECTORY'];
        if (!is_dir($directory)) {
            if (!mkdir($directory, 0644, true)) {
                throw new Exception('Creating path directory for pickup points files is failed.');
            }
        }
        return $directory;
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