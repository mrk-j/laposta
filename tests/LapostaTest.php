<?php

use GuzzleHttp\Client;
use Mrkj\Laposta\Laposta;
use PHPUnit\Framework\TestCase;

class LapostaTest extends TestCase
{
    /**
     * @var string
     */
    private $apiKey = 'foo';

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
            ->shouldReceive('get')
            ->withArgs(['list'])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], file_get_contents(__DIR__.'/fixtures/list.json')));

        $lists = $this->laposta->getLists();

        $this->assertInternalType('array', $lists);
        $this->assertContainsOnlyInstancesOf(\Mrkj\Laposta\Models\List_::class, $lists);
        $this->assertCount(1, $lists);
        $this->assertEquals('Testlijst', $lists[0]->getName());
    }
}
