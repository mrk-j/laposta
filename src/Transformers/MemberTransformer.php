<?php

namespace Mrkj\Laposta\Transformers;

use Mrkj\Laposta\Models\Member;

class MemberTransformer
{
    /**
     * @param Member $member
     * @param bool $suppressEmailNotification
     * @param bool $suppressEmailWelcome
     * @param bool $ignoreDoubleOptin
     * @return array
     */
    public static function toFormParamsForCreate(
        Member $member,
        $suppressEmailNotification = false,
        $suppressEmailWelcome = false,
        $ignoreDoubleOptin = false
    ): array {
        $formParams = [
            'list_id' => $member->listId,
            'ip' => $member->ip,
            'email' => $member->email,
        ];

        if ($member->sourceUrl) {
            $formParams['source_url'] = $member->sourceUrl;
        }

        if (count($member->getCustomFields()) > 0) {
            $formParams['custom_fields'] = $member->getCustomFields();
        }

        $options = [];

        if ($suppressEmailNotification) {
            $options['suppress_email_notification'] = true;
        }

        if ($suppressEmailWelcome) {
            $options['suppress_email_welcome'] = true;
        }

        if ($ignoreDoubleOptin) {
            $options['ignore_doubleoptin'] = true;
        }

        if (count($options) > 0) {
            $formParams['options'] = $options;
        }

        return $formParams;
    }

    /**
     * @param Member $member
     * @return array
     */
    public static function toFormParamsForUpdate(Member $member): array
    {
        $formParams = [
            'list_id' => $member->listId,
        ];

        if ($member->email) {
            $formParams['email'] = $member->email;
        }

        if ($member->state && in_array($member->state, [Member::STATE_ACTIVE, Member::STATE_UNSUBSCRIBED])) {
            $formParams['state'] = $member->state;
        }

        if (count($member->getCustomFields()) > 0) {
            $formParams['custom_fields'] = $member->getCustomFields();
        }

        return $formParams;
    }
}
