<?php

namespace App\Services;

class ShipbuddyService
{
    protected $apiKey;
    protected $baseUrl;
    protected $client;

    public function __construct()
    {
        $this->apiKey  = getenv('shipbudddy.api_key');
        $this->baseUrl = rtrim(getenv('shipbudddy.baseUrl'), '/') . '/';

        $this->client = \Config\Services::curlrequest([
            'timeout' => 30
        ]);
    }

    private function request($endpoint, $method = 'GET', $data = [])
    {
        try {

            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type'  => 'application/json'
                ]
            ];

            if ($method === 'POST') {
                $options['json'] = $data;
            }

            $response = $this->client->request(
                $method,
                $this->baseUrl . $endpoint,
                $options
            );

            $body = json_decode($response->getBody(), true);

            return [
                'success' => true,
                'data' => $body
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function createShipment($data)
    {
        return $this->request('shipments/create', 'POST', $data);
    }

    public function trackShipment($trackingNumber)
    {
        return $this->request('shipments/track/' . $trackingNumber);
    }
}