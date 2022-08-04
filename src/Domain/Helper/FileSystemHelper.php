<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\Helper;

use Exception;

class FileSystemHelper
{
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

}