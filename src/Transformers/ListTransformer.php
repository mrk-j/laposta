<?php

namespace Mrkj\Laposta\Transformers;

use Mrkj\Laposta\Models\List_;

class ListTransformer
{
    /**
     * @param List_ $list
     * @return array
     */
    public static function toFormParams(List_ $list) : array
    {
        return [
            'name' => $list->getName(),
            'remarks' => $list->getRemarks(),
            'subscribe_notification_email' => $list->getSubscribeNotificationEmail(),
            'unsubscribe_notification_email' => $list->getUnsubsribeNotificationEmail(),
        ];
    }
}
