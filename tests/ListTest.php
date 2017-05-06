<?php

use Mrkj\Laposta\Models\List_;
use PHPUnit\Framework\TestCase;

class ListTest extends TestCase
{
    function testSettersAndGetters()
    {
        $list = new List_();

        $list->setAccountId('accountId');
        $this->assertEquals('accountId', $list->getAccountId());

        $list->setListId('listId');
        $this->assertEquals('listId', $list->getListId());

        $list->setNumberOfCleanedMembers('numberOfCleanedMembers');
        $this->assertEquals('numberOfCleanedMembers', $list->getNumberOfCleanedMembers());
    }
}
