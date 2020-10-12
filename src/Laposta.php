<?php

namespace Mrkj\Laposta;

use GuzzleHttp\Client;
use Mrkj\Laposta\Models\List_;
use Mrkj\Laposta\Models\Member;
use Mrkj\Laposta\Transformers\ListTransformer;
use Mrkj\Laposta\Transformers\MemberTransformer;

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
    public function getLists(): array
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
    public function getList($listId): List_
    {
        $data = $this->get('list/'.$listId);

        $list = List_::createFromResponse($data['list']);

        return $list;
    }

    /**
     * @param $name
     * @param null $remarks
     * @param null $subscribeNotificationEmail
     * @param null $unsubsribeNotificationEmail
     * @return List_
     */
    public function createList(
        $name,
        $remarks = null,
        $subscribeNotificationEmail = null,
        $unsubsribeNotificationEmail = null
    ): List_ {
        $list = new List_();
        $list->name = $name;
        $list->remarks = $remarks;
        $list->subscribeNotificationEmail = $subscribeNotificationEmail;
        $list->unsubsribeNotificationEmail = $unsubsribeNotificationEmail;

        $data = $this->post('list', [
            'form_params' => ListTransformer::toFormParams($list),
        ]);

        $list->updateFromResponse($data['list']);

        return $list;
    }

    /**
     * @param List_ $list
     */
    public function updateList(List_ $list)
    {
        $data = $this->post('list/'.$list->id, [
            'form_params' => ListTransformer::toFormParams($list),
        ]);

        $list->updateFromResponse($data['list']);
    }

    /**
     * @param List_ $list
     */
    public function deleteList(List_ $list)
    {
        $data = $this->delete('list/'.$list->id);

        $list->updateFromResponse($data['list']);
    }

    /**
     * @param List_|string $list
     * @param string $state
     * @return Member[]
     */
    public function getMembers($list, $state = Member::STATE_ACTIVE): array
    {
        $listId = $list instanceof List_ ? $list->id : $list;

        $params = ['list_id' => $listId];

        if (! is_null($state) && in_array($state, Member::STATES)) {
            $params['state'] = $state;
        }

        $data = $this->get('member?'.http_build_query($params));

        $members = [];

        foreach ($data['data'] as $listResponse) {
            $members[] = Member::createFromResponse($listResponse['member']);
        }

        return $members;
    }

    /**
     * @param List_|string $list
     * @param string $memberId
     * @return Member
     */
    public function getMember($list, string $memberId): Member
    {
        $listId = $list instanceof List_ ? $list->id : $list;

        $data = $this->get('member/'.$memberId.'?'.http_build_query(['list_id' => $listId]));

        $member = Member::createFromResponse($data['member']);

        return $member;
    }

    /**
     * @param $listId
     * @param $email
     * @param $ip
     * @param array $customFields
     * @param null $sourceUrl
     * @param bool $suppressEmailNotification
     * @param bool $suppressEmailWelcome
     * @param bool $ignoreDoubleOptin
     * @return Member
     */
    public function createMember(
        $listId,
        $email,
        $ip = null,
        $customFields = [],
        $sourceUrl = null,
        $suppressEmailNotification = false,
        $suppressEmailWelcome = false,
        $ignoreDoubleOptin = false
    ): Member {
        $member = new Member();
        $member->listId = $listId;
        $member->email = $email;
        $member->ip = $ip ?? (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1');
        $member->setCustomFields($customFields);
        $member->sourceUrl = $sourceUrl;

        $data = $this->post('member', [
            'form_params' => MemberTransformer::toFormParamsForCreate(
                $member,
                $suppressEmailNotification,
                $suppressEmailWelcome,
                $ignoreDoubleOptin
            ),
        ]);

        $member->updateFromResponse($data['member']);

        return $member;
    }

    /**
     * @param Member $member
     */
    public function updateMember(Member $member)
    {
        $data = $this->post('member/'.$member->id.'?'.http_build_query(['list_id' => $member->listId]), [
            'form_params' => MemberTransformer::toFormParamsForUpdate($member),
        ]);

        $member->updateFromResponse($data['member']);
    }

    /**
     * @param Member $member
     */
    public function deleteMember(Member $member)
    {
        $data = $this->delete('member/'.$member->id.'?'.http_build_query(['list_id' => $member->listId]));

        $member->updateFromResponse($data['member']);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    private function get($uri, $options = []): array
    {
        return $this->request('get', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    private function post($uri, $options = []): array
    {
        return $this->request('post', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     * @return array
     */
    private function delete($uri, $options = []): array
    {
        return $this->request('delete', $uri, $options);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return array
     */
    private function request($method, $uri, $options = []): array
    {
        $response = $this->client->request($method, $uri, $options);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }
}
