<?php

namespace Infrastructure\Connector;

use PHPUnit\Framework\TestCase;

final class ConnectorApiTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => 'https://sandbox-api-gateway-pl.easypack24.net/']);
        $dotenv = \Dotenv\Dotenv::createImmutable('/var/www/html/config/');
        $dotenv->load();
    }

    public function testDoRequest()
    {
        $params = [
            'headers' => ['Authorization' => 'Bearer ' . $_ENV['INPOST_API_TOKEN']]
        ];

        $filters = '?page=1&per_page=25';
        $response = $this->client->request('GET', 'v1/points' . $filters, $params);

        $this->assertEquals(200, $response->getStatusCode());
    }
}