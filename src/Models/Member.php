<?php

namespace Mrkj\Laposta\Models;

class Member
{
    public $id;
    public $listId;
    public $email;
    public $state;
    public $signupDate;
    public $modified;
    public $ip;
    public $sourceUrl;
    private $customFields = [];

    const STATE_ACTIVE = 'active';
    const STATE_UNSUBSCRIBED = 'unsubscribed';
    const STATE_CLEANED = 'cleaned';
    const STATE_DELETED = 'deleted';

    const STATES = [
        self::STATE_ACTIVE,
        self::STATE_UNSUBSCRIBED,
        self::STATE_CLEANED,
        self::STATE_DELETED,
    ];

    /**
     * @param array $response
     * @return Member
     */
    public static function createFromResponse(array $response): self
    {
        $self = new self;

        $self->updateFromResponse($response);

        return $self;
    }

    /**
     * @param array $response
     */
    public function updateFromResponse(array $response)
    {
        $this->id = $response['member_id'];
        $this->listId = $response['list_id'];
        $this->email = $response['email'];
        $this->state = $response['state'];
        $this->signupDate = $response['signup_date'];
        $this->modified = $response['modified'];
        $this->ip = $response['ip'];
        $this->sourceUrl = $response['source_url'];

        $this->setCustomFields($response['custom_fields']);
    }

    /**
     * @return array
     */
    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    /**
     * @param array|null $customFields
     */
    public function setCustomFields($customFields)
    {
        if (is_array($customFields)) {
            $this->customFields = $customFields;
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function setCustomField($key, $value)
    {
        $this->customFields[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getCustomField($key)
    {
        return isset($this->customFields[$key]) ? $this->customFields[$key] : null;
    }
}
