<?php

namespace Infrastructure\Connector;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

final class ConnectorApiTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        $this->client = new Client(['base_uri' => 'https://sandbox-api-gateway-pl.easypack24.net/']);
        $dotenv = Dotenv::createImmutable('config/');
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