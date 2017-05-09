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
        $this->assertEquals('Testlijst', $lists[0]->name);
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
        $this->assertEquals('Testlijst', $list->name);
        $this->assertEquals($listId, $list->id);
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
                    'name' => $list->name,
                    'remarks' => $list->remarks,
                    'subscribe_notification_email' => $list->subscribeNotificationEmail,
                    'unsubscribe_notification_email' => $list->unsubsribeNotificationEmail,
                ],
            ]])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], $json));

        $this->laposta->updateList($list);

        $this->assertInstanceOf(\Mrkj\Laposta\Models\List_::class, $list);
        $this->assertEquals('Testlijst', $list->name);
        $this->assertEquals($listId, $list->id);
    }

    public function testCreateList()
    {
        $listId = '0a9b0ddz67';

        $list = new \Mrkj\Laposta\Models\List_();
        $list->name = 'Testlijst';

        $this->client
            ->shouldReceive('request')
            ->withArgs(['post', 'list', [
                'form_params' => [
                    'name' => $list->name,
                    'remarks' => $list->remarks,
                    'subscribe_notification_email' => $list->subscribeNotificationEmail,
                    'unsubscribe_notification_email' => $list->unsubsribeNotificationEmail,
                ],
            ]])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], file_get_contents(__DIR__.'/fixtures/list.json')));

        $this->laposta->createList($list);

        $this->assertInstanceOf(\Mrkj\Laposta\Models\List_::class, $list);
        $this->assertEquals('Testlijst', $list->name);
        $this->assertEquals($listId, $list->id);
    }

    public function testDeleteList()
    {
        $listId = '0a9b0ddz67';

        $json = file_get_contents(__DIR__.'/fixtures/list-deleted.json');

        $list = \Mrkj\Laposta\Models\List_::createFromResponse(json_decode($json, true)['list']);

        $this->client
            ->shouldReceive('request')
            ->withArgs(['delete', 'list/'.$listId, []])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], $json));

        $this->laposta->deleteList($list);

        $this->assertInstanceOf(\Mrkj\Laposta\Models\List_::class, $list);
        $this->assertEquals('Testlijst', $list->name);
        $this->assertEquals($listId, $list->id);
        $this->assertEquals('deleted', $list->state);
    }

    public function testGetMembers()
    {
        $listId = '0a9b0ddz67';

        $this->client
            ->shouldReceive('request')
            ->withArgs(['get', 'member?list_id='.$listId.'&state=active', []])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], file_get_contents(__DIR__.'/fixtures/members.json')));

        $members = $this->laposta->getMembers($listId);

        $this->assertInternalType('array', $members);
        $this->assertContainsOnlyInstancesOf(\Mrkj\Laposta\Models\Member::class, $members);
        $this->assertCount(2, $members);
        $this->assertEquals('maartje@example.net', $members[0]->email);
    }

    public function testGetMember()
    {
        $memberId = '9978ydioiZ';
        $listId = '0a9b0ddz67';

        $this->client
            ->shouldReceive('request')
            ->withArgs(['get', 'member/'.$memberId.'?list_id='.$listId, []])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], file_get_contents(__DIR__.'/fixtures/member.json')));

        $member = $this->laposta->getMember($listId, $memberId);

        $this->assertInstanceOf(\Mrkj\Laposta\Models\Member::class, $member);
        $this->assertEquals('maartje@example.net', $member->email);
        $this->assertEquals($listId, $member->listId);
        $this->assertEquals($memberId, $member->id);
    }

    public function testUpdateMember()
    {
        $memberId = '9978ydioiZ';
        $listId = '0a9b0ddz67';

        $json = file_get_contents(__DIR__.'/fixtures/member.json');

        $member = \Mrkj\Laposta\Models\Member::createFromResponse(json_decode($json, true)['member']);

        $this->client
            ->shouldReceive('request')
            ->withArgs(['post', 'member/'.$memberId.'?list_id='.$listId, [
                'form_params' => [
                    'list_id' => $member->listId,
                    'email' => $member->email,
                    'state' => $member->state,
                    'custom_fields' => $member->getCustomFields(),
                ],
            ]])
            ->once()
            ->andReturn(new \GuzzleHttp\Psr7\Response(200, [], $json));

        $this->laposta->updateMember($member);

        $this->assertInstanceOf(\Mrkj\Laposta\Models\Member::class, $member);
        $this->assertEquals('maartje@example.net', $member->email);
        $this->assertEquals('optionA', $member->getCustomFields()['prefs'][0]);
    }
}
