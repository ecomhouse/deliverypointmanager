<?php
declare(strict_types=1);

namespace EcomHouse\DeliveryPoints\Infrastructure\Connector;

use EcomHouse\DeliveryPoints\Domain\Helper\FileSystemHelper;

class ConnectorUri implements ConnectorInterface
{
    const PATH = 'var/data/';
    private FileSystemHelper $fileSystemHelper;

    public function __construct()
    {
        $this->fileSystemHelper = new FileSystemHelper();
    }

    public function doRequest(string $uriEndpoint, array $params = [], string $requestMethod = 'GET')
    {
        $fileName = $this->fileSystemHelper->getFileDirectory() . basename($uriEndpoint);
        file_put_contents($fileName, file_get_contents($uriEndpoint));

        return $fileName;
    }
}