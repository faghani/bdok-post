<?php

namespace Bdok\PostGateway;

use GuzzleHttp\Client as HttpClient;

class Client {
    use MakesHttpRequests,
        Actions\GetPrice,
        Actions\NewOrder,
        Actions\ChangeState;

    /**
     * The Gateway API Key.
     *
     * @var string
     */
    public $apiKey;

    /**
     * The Guzzle HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    public $guzzle;

    /**
     * Api base url
     *
     * @var string
     */
    public $apiBaseUri = 'http://localhost/main/api/'; // @todo change to bdok.ir api!

    /**
     * Create a new Client instance.
     *
     * @param  string $apiKey
     * @param  \GuzzleHttp\Client $guzzle
     * @return void
     */
    public function __construct($apiKey, HttpClient $guzzle = null)
    {
        $this->apiKey = $apiKey;

        $this->guzzle = $guzzle ?: new HttpClient([
            'base_uri' => $this->apiBaseUri,
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer '.$this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}