<?php

namespace Mrkj\Transformers;

class ListTransformer
{
    public static function toFormParams(List_ $list)
    {
        return [
            'name' => $list->getName(),
            'remarks' => $list->getRemarks(),
            'subscribe_notification_email' => $list->getSubscribeNotificationEmail(),
            'unsubscribe_notification_email' => $list->getUnsubsribeNotificationEmail(),
        ];
    }
}