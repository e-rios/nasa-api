<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class NasaService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.nasa.gov/',
        ]);
        $this->apiKey = env('NASA_API_KEY');
    }

    public function getDonkiData($endpoint)
    {
        $response = $this->client->get("DONKI/$endpoint", [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}