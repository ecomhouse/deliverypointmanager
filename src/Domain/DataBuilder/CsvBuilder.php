<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\DataBuilder;

use EcomHouse\DeliveryPoints\Domain\Helper\FileSystemHelper;

class CsvBuilder implements DataBuilderInterface
{
    const FILE_EXTENSION = 'csv';
    private const DELIMITER = ',';
    private FileSystemHelper $fileSystemHelper;

    public function __construct()
    {
        $this->fileSystemHelper = new FileSystemHelper();
    }

    public function build(string $filename, array $data, array $headers): void
    {
        $file = fopen($this->fileSystemHelper->getFileDirectory() . $filename . '.' . self::FILE_EXTENSION, 'w');
        fputcsv($file, $headers, self::DELIMITER);

        foreach ($data as $row) {
            if (is_object($row)) {
                $row = $row->toArray();
            }
            fputcsv($file, $row);
        }

        fclose($file);
    }

    public function getFileExtension(): string
    {
        return self::FILE_EXTENSION;
    }
}