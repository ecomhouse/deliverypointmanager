<?php
declare(strict_types=1);

namespace Infrastructure\Connector;

use EcomHouse\DeliveryPoints\Infrastructure\Connector\ConnectorUri;
use PHPUnit\Framework\TestCase;

class ConnectorUriTest extends TestCase
{
    protected ConnectorUri $connectorUri;

    protected function setUp(): void
    {
        $this->connectorUri = new ConnectorUri;
    }

    public function testDoRequest()
    {
        $url = 'https://placowki.poczta-polska.pl/pliki-owp.php?t=csvK48S';
        $filename = $this->connectorUri->doRequest($url);

        $this->assertFileExists($filename);
        unlink($filename);
    }
}