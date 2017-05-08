<?php

namespace Mrkj\Laposta;

use GuzzleHttp\Client;
use Mrkj\Laposta\Models\List_;
use GuzzleHttp\Exception\RequestException;
use Mrkj\Laposta\Transformers\ListTransformer;

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

    /**
     * Laposta constructor.
     * @param null|string $apiKey
     * @param null|Client $client
     * @throws \Exception
     */
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
    public function getLists() : array
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
     * @return List_
     */
    public function getList($listId) : List_
    {
        $data = $this->get('list/'.$listId);

        $list = List_::createFromResponse($data['list']);

        return $list;
    }

    /**
     * @param List_ $list
     */
    public function createList(List_ $list)
    {
        $data = $this->post('list', [
            'form_params' => ListTransformer::toFormParams($list),
        ]);

        $list->updateFromResponse($data['list']);
    }

    /**
     * @param List_ $list
     */
    public function updateList(List_ $list)
    {
        $data = $this->post('list/'.$list->getListId(), [
            'form_params' => ListTransformer::toFormParams($list),
        ]);

        $list->updateFromResponse($data['list']);
    }

    /**
     * @param List_ $list
     */
    public function deleteList(List_ $list)
    {
        $data = $this->delete('list/'.$list->getListId());

        $list->updateFromResponse($data['list']);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    private function get($uri, $options = []) : array
    {
        return $this->request('get', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    private function post($uri, $options = []) : array
    {
        return $this->request('post', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return array
     */
    private function delete($uri, $options = []) : array
    {
        return $this->request('delete', $uri, $options);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return array
     */
    private function request($method, $uri, $options = []) : array
    {
        $response = $this->client->request($method, $uri, $options);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }
}