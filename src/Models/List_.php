<?php

namespace Mrkj\Laposta\Models;

class List_
{
    private $accountId;
    private $listId;
    private $created;
    private $modified;
    private $state;
    private $name;
    private $remarks;
    private $subscribeNotificationEmail;
    private $unsubsribeNotificationEmail;
    private $numberOfActiveMembers;
    private $numberOfUnsubscribedMembers;
    private $numberOfCleanedMembers;

    /**
     * @param array $response
     * @return List_
     */
    public static function createFromResponse(array $response) : List_
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
        $this->setAccountId($response['account_id']);
        $this->setListId($response['list_id']);
        $this->setCreated($response['created']);
        $this->setModified($response['modified']);
        $this->setState($response['state']);
        $this->setName($response['name']);
        $this->setRemarks($response['remarks']);
        $this->setSubscribeNotificationEmail($response['subscribe_notification_email']);
        $this->setUnsubsribeNotificationEmail($response['unsubscribe_notification_email']);
        $this->setNumberOfActiveMembers($response['members']['active']);
        $this->setNumberOfUnsubscribedMembers($response['members']['unsubscribed']);
        $this->setNumberOfCleanedMembers($response['members']['cleaned']);
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param mixed $accountId
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
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
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param mixed $remarks
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    }

    /**
     * @return mixed
     */
    public function getSubscribeNotificationEmail()
    {
        return $this->subscribeNotificationEmail;
    }

    /**
     * @param mixed $subscribeNotificationEmail
     */
    public function setSubscribeNotificationEmail($subscribeNotificationEmail)
    {
        $this->subscribeNotificationEmail = $subscribeNotificationEmail;
    }

    /**
     * @return mixed
     */
    public function getUnsubsribeNotificationEmail()
    {
        return $this->unsubsribeNotificationEmail;
    }

    /**
     * @param mixed $unsubsribeNotificationEmail
     */
    public function setUnsubsribeNotificationEmail($unsubsribeNotificationEmail)
    {
        $this->unsubsribeNotificationEmail = $unsubsribeNotificationEmail;
    }

    /**
     * @return mixed
     */
    public function getNumberOfActiveMembers()
    {
        return $this->numberOfActiveMembers;
    }

    /**
     * @param mixed $numberOfActiveMembers
     */
    public function setNumberOfActiveMembers($numberOfActiveMembers)
    {
        $this->numberOfActiveMembers = $numberOfActiveMembers;
    }

    /**
     * @return mixed
     */
    public function getNumberOfUnsubscribedMembers()
    {
        return $this->numberOfUnsubscribedMembers;
    }

    /**
     * @param mixed $numberOfUnsubscribedMembers
     */
    public function setNumberOfUnsubscribedMembers($numberOfUnsubscribedMembers)
    {
        $this->numberOfUnsubscribedMembers = $numberOfUnsubscribedMembers;
    }

    /**
     * @return mixed
     */
    public function getNumberOfCleanedMembers()
    {
        return $this->numberOfCleanedMembers;
    }

    /**
     * @param mixed $numberOfCleanedMembers
     */
    public function setNumberOfCleanedMembers($numberOfCleanedMembers)
    {
        $this->numberOfCleanedMembers = $numberOfCleanedMembers;
    }
}
