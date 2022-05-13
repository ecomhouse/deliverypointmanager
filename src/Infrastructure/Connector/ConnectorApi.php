<?php

namespace EcomHouse\DeliveryPoints\Infrastructure\Connector;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class ConnectorApi implements ConnectorInterface
{
    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * @param GuzzleClient $client
     */
    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     * @return Response|\Psr\Http\Message\ResponseInterface
     */
    public function doRequest(string $uriEndpoint, array $params = [], string $requestMethod = 'GET')
    {
        try {
            $response = $this->client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = [
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ];
        }

        return $response;
    }

}
