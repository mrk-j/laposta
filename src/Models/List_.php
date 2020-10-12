<?php

namespace Mrkj\Laposta\Models;

class List_
{
    public $accountId;
    public $id;
    public $created;
    public $modified;
    public $state;
    public $name;
    public $remarks;
    public $subscribeNotificationEmail;
    public $unsubsribeNotificationEmail;
    public $numberOfActiveMembers;
    public $numberOfUnsubscribedMembers;
    public $numberOfCleanedMembers;

    /**
     * @param array $response
     * @return List_
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
        $this->accountId = $response['account_id'];
        $this->id = $response['list_id'];
        $this->created = $response['created'];
        $this->modified = $response['modified'];
        $this->state = $response['state'];
        $this->name = $response['name'];
        $this->remarks = $response['remarks'];
        $this->subscribeNotificationEmail = $response['subscribe_notification_email'];
        $this->unsubsribeNotificationEmail = $response['unsubscribe_notification_email'];
        $this->numberOfActiveMembers = $response['members']['active'];
        $this->numberOfUnsubscribedMembers = $response['members']['unsubscribed'];
        $this->numberOfCleanedMembers = $response['members']['cleaned'];
    }
}
