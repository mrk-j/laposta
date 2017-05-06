<?php

namespace Mrkj\Laposta;

use GuzzleHttp\Client;
use Mrkj\Laposta\Models\List_;
use GuzzleHttp\Exception\RequestException;

class Laposta
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var Client
     */
    private $client;

    public function __construct($apiKey = null, $client = null)
    {
        if (empty(trim($apiKey))) {
            throw new \Exception('No API key provided');
        }

        $this->apiKey = $apiKey;

        if ($client && $client instanceof Client) {
            $this->client = $client;
        } else {
            $this->client = new Client([
                'base_uri' => 'https://api.laposta.nl/v2/',
                'auth' => [$this->apiKey, ''],
                'http_errors' => true,
            ]);
        }
    }

    public function getLists()
    {
        $data = $this->getJson('list');

        $lists = [];

        foreach ($data['data'] as $listResponse) {
            $lists[] = List_::createFromResponse($listResponse);
        }

        return $lists;
    }

    private function getJson($uri)
    {
        try {
            $response = $this->client->get($uri);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data;
        } catch (RequestException $e) {
            throw new \Exception('No connection to Laposta');
        }
    }
}
