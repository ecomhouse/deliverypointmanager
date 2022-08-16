<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Domain\DataBuilder;

use EcomHouse\DeliveryPoints\Domain\Helper\FileSystemHelper;

class XmlBuilder implements DataBuilderInterface
{
    const FILE_EXTENSION = 'xml';
    private FileSystemHelper $fileSystemHelper;

    public function __construct()
    {
        $this->fileSystemHelper = new FileSystemHelper();
    }

    public function build(string $filename, array $data, array $headers): void
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $root = $dom->createElement('points');
        $dom->appendChild($root);
        foreach ($data as $key => $value) {
            $result = $dom->createElement('point');
            $root->appendChild($result);
            if (is_object($value)) {
                $value = $value->toArray();
            }

            if (is_array($value)) {
                foreach ($value as $k => $item) {
                    $result->appendChild($dom->createElement($k, htmlspecialchars((string)$item ?? '', ENT_QUOTES)));
                }
            } else {
                $result->appendChild($dom->createElement($key, $value));
            }
        }

        $dom->save($this->fileSystemHelper->getFileDirectory() . $filename . '.'.self::FILE_EXTENSION);
    }

    public function getFileExtension(): string
    {
        return self::FILE_EXTENSION;
    }
}