<?php

namespace EcomHouse\DeliveryPoints\Domain\Helper;

class FileSystemHelper
{
    public function getFileDirectory(): string
    {
        $directory = $_ENV['FILE_PATH_DIRECTORY'];
        if (!is_dir($directory)) {
            mkdir($directory);
        }
        return $directory;
    }

}