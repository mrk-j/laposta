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
            'name' => $list->name,
            'remarks' => $list->remarks,
            'subscribe_notification_email' => $list->subscribeNotificationEmail,
            'unsubscribe_notification_email' => $list->unsubsribeNotificationEmail,
        ];
    }
}
