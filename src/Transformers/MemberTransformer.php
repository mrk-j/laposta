<?php

namespace Mrkj\Laposta\Transformers;

use Mrkj\Laposta\Models\Member;

class MemberTransformer
{
    /**
     * @param Member $member
     * @return array
     */
    public static function toFormParams(Member $member) : array
    {
        return [
            'list_id' => $member->listId,
            'email' => $member->email,
            'state' => $member->state,
            'custom_fields' => $member->getCustomFields(),
        ];
    }
}
