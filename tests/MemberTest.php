<?php

use Mrkj\Laposta\Models\Member;
use PHPUnit\Framework\TestCase;

class MemberTest extends TestCase
{
    public function testSettersAndGetters()
    {
        $member = new Member();

        $member->setMemberId('memberId');
        $this->assertEquals('memberId', $member->getMemberId());

        $member->setListId('listId');
        $this->assertEquals('listId', $member->getListId());

        $member->setCustomFields(['foo' => 'bar']);
        $this->assertEquals('bar', $member->getCustomFields()['foo']);
        $this->assertCount(1, $member->getCustomFields());
    }
}
