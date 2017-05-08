<?php

namespace Mrkj\Laposta\Models;

class Member
{
    private $memberId;
    private $listId;
    private $email;
    private $state;
    private $signupDate;
    private $modified;
    private $ip;
    private $sourceUrl;
    private $customFields = [];

    const STATE_ACTIVE = 'active';
    const STATE_UNSUBSCRIBED = 'unsubscribed';
    const STATE_CLEANED = 'cleaned';

    const STATES = [self::STATE_ACTIVE, self::STATE_UNSUBSCRIBED, self::STATE_CLEANED];

    /**
     * @param array $response
     * @return Member
     */
    public static function createFromResponse(array $response) : Member
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
        $this->setMemberId($response['member_id']);
        $this->setListId($response['list_id']);
        $this->setEmail($response['email']);
        $this->setState($response['state']);
        $this->setSignupDate($response['signup_date']);
        $this->setModified($response['modified']);
        $this->setIp($response['ip']);
        $this->setSourceUrl($response['source_url']);
        $this->setCustomFields($response['custom_fields']);
    }

    /**
     * @return mixed
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @param mixed $memberId
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @param mixed $listId
     */
    public function setListId($listId)
    {
        $this->listId = $listId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getSignupDate()
    {
        return $this->signupDate;
    }

    /**
     * @param mixed $signupDate
     */
    public function setSignupDate($signupDate)
    {
        $this->signupDate = $signupDate;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    /**
     * @param mixed $sourceUrl
     */
    public function setSourceUrl($sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;
    }

    /**
     * @return array
     */
    public function getCustomFields() : array
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
}
