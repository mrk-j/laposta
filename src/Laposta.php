<?php

namespace Mrkj\Laposta;

use GuzzleHttp\Client;
use Mrkj\Laposta\Models\List_;
use GuzzleHttp\Exception\RequestException;
use Mrkj\Transformers\ListTransformer;

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

    /**
     * @return List_[]
     */
    public function getLists()
    {
        $data = $this->get('list');

        $lists = [];

        foreach ($data['data'] as $listResponse) {
            $lists[] = List_::createFromResponse($listResponse['list']);
        }

        return $lists;
    }

    /**
     * @param $listId
     * @return bool|List_
     */
    public function getList($listId)
    {
        $data = $this->get('list/'.$listId);

        $list = List_::createFromResponse($data['list']);

        return $list;
    }

    public function createList(List_ $list)
    {
        $data = $this->post('list', [
            'form_params' => ListTransformer::toFormParams($list),
        ]);

        $list->updateFromResponse($data['list']);
    }

    public function updateList(List_ $list)
    {
        $this->client->post('list/'.$list->getListId(), [
            'form_params' => ListTransformer::toFormParams($list),
        ]);
    }

    private function get($uri, $options = [])
    {
        return $this->request('get', $uri, $options);
    }

    private function post($uri, $options = [])
    {
        return $this->request('post', $uri, $options);
    }

    private function request($method, $uri, $options = [])
    {
        try {
            $response = $this->client->request($method, $uri, $options);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data;
        } catch (RequestException $e) {
            throw new \Exception('Loading Laposta resource failed: '.$e->getMessage());
        }
    }
}
