<?php

use GuzzleHttp\Client;
use Mrkj\Laposta\Laposta;
use PHPUnit\Framework\TestCase;

class LapostaTest extends TestCase
{
    /**
     * @var string
     */
    private $apiKey = 'JdMtbsMq2jqJdQZD9AHC';

    /**
     * @var Laposta
     */
    private $laposta;

    /**
     * @var Client|\Mockery\Mock
     */
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);

        $this->laposta = new Laposta($this->apiKey, $this->client);
    }

    public function testEmptyApiKey()
    {
        $this->expectException('\Exception');

        new Laposta('');
    }

    public function testNoApiKey()
    {
        $this->expectException('\Exception');

        new Laposta();
    }

    public function testGetLists()
    {
        $this->client
            ->shouldReceive('request')
            ->withArgs(['get', 'list', []])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], file_get_contents(__DIR__.'/fixtures/lists.json')));

        $lists = $this->laposta->getLists();

        $this->assertInternalType('array', $lists);
        $this->assertContainsOnlyInstancesOf(\Mrkj\Laposta\Models\List_::class, $lists);
        $this->assertCount(1, $lists);
        $this->assertEquals('Testlijst', $lists[0]->getName());
    }

    public function testGetList()
    {
        $listId = '0a9b0ddz67';

        $this->client
            ->shouldReceive('request')
            ->withArgs(['get', 'list/'.$listId, []])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], file_get_contents(__DIR__.'/fixtures/list.json')));

        $list = $this->laposta->getList($listId);

        $this->assertInstanceOf(\Mrkj\Laposta\Models\List_::class, $list);
        $this->assertEquals('Testlijst', $list->getName());
        $this->assertEquals($listId, $list->getListId());
    }

    public function testUpdateList()
    {
        $listId = '0a9b0ddz67';

        $json = file_get_contents(__DIR__.'/fixtures/list.json');

        $list = \Mrkj\Laposta\Models\List_::createFromResponse(json_decode($json, true)['list']);

        $this->client
            ->shouldReceive('request')
            ->withArgs(['post', 'list/'.$listId, [
                'form_params' => [
                    'name' => $list->getName(),
                    'remarks' => $list->getRemarks(),
                    'subscribe_notification_email' => $list->getSubscribeNotificationEmail(),
                    'unsubscribe_notification_email' => $list->getUnsubsribeNotificationEmail(),
                ],
            ]])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], $json));

        $this->laposta->updateList($list);

        $this->assertInstanceOf(\Mrkj\Laposta\Models\List_::class, $list);
        $this->assertEquals('Testlijst', $list->getName());
        $this->assertEquals($listId, $list->getListId());
    }

    public function testCreateList()
    {
        $listId = '0a9b0ddz67';

        $list = new \Mrkj\Laposta\Models\List_();
        $list->setName('Testlijst');

        $this->client
            ->shouldReceive('request')
            ->withArgs(['post', 'list', [
                'form_params' => [
                    'name' => $list->getName(),
                    'remarks' => $list->getRemarks(),
                    'subscribe_notification_email' => $list->getSubscribeNotificationEmail(),
                    'unsubscribe_notification_email' => $list->getUnsubsribeNotificationEmail(),
                ],
            ]])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], file_get_contents(__DIR__.'/fixtures/list.json')));

        $this->laposta->createList($list);

        $this->assertInstanceOf(\Mrkj\Laposta\Models\List_::class, $list);
        $this->assertEquals('Testlijst', $list->getName());
        $this->assertEquals($listId, $list->getListId());
    }
}
