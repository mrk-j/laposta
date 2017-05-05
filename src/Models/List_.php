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
     * @return mixed
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @return mixed
     */
    public function getSubscribeNotificationEmail()
    {
        return $this->subscribeNotificationEmail;
    }

    /**
     * @return mixed
     */
    public function getUnsubsribeNotificationEmail()
    {
        return $this->unsubsribeNotificationEmail;
    }

    /**
     * @return mixed
     */
    public function getNumberOfActiveMembers()
    {
        return $this->numberOfActiveMembers;
    }

    /**
     * @return mixed
     */
    public function getNumberOfUnsubscribedMembers()
    {
        return $this->numberOfUnsubscribedMembers;
    }

    /**
     * @return mixed
     */
    public function getNumberOfCleanedMembers()
    {
        return $this->numberOfCleanedMembers;
    }
}