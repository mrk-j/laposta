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

    public function __construct(
        $accountId,
        $listId,
        $created,
        $modified,
        $state,
        $name,
        $remarks,
        $subscribeNotificationEmail,
        $unsubsribeNotificationEmail,
        $numberOfActiveMembers,
        $numberOfUnsubscribedMembers,
        $numberOfCleanedMembers
    ) {
        $this->accountId = $accountId;
        $this->listId = $listId;
        $this->created = $created;
        $this->modified = $modified;
        $this->state = $state;
        $this->name = $name;
        $this->remarks = $remarks;
        $this->subscribeNotificationEmail = $subscribeNotificationEmail;
        $this->unsubsribeNotificationEmail = $unsubsribeNotificationEmail;
        $this->numberOfActiveMembers = $numberOfActiveMembers;
        $this->numberOfUnsubscribedMembers = $numberOfUnsubscribedMembers;
        $this->numberOfCleanedMembers = $numberOfCleanedMembers;
    }

    public static function createFromResponse($response)
    {
        if ($response['list']) {
            $list = $response['list'];

            return new self(
                $list['account_id'],
                $list['list_id'],
                $list['created'],
                $list['modified'],
                $list['state'],
                $list['name'],
                $list['remarks'],
                $list['subscribe_notification_email'],
                $list['unsubscribe_notification_email'],
                $list['members']['active'],
                $list['members']['unsubscribed'],
                $list['members']['cleaned']
            );
        }

        return false;
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