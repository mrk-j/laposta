<?php

namespace Mrkj\Laposta\Transformers;

use Mrkj\Laposta\Models\List_;

class ListTransformer
{
    /**
     * @param List_ $list
     * @return array
     */
    public static function toFormParams(List_ $list): array
    {
        $formParams = [
            'name' => $list->name,
        ];

        if ($list->remarks) {
            $formParams['remarks'] = $list->remarks;
        }

        if ($list->subscribeNotificationEmail) {
            $formParams['subscribe_notification_email'] = $list->subscribeNotificationEmail;
        }

        if ($list->unsubsribeNotificationEmail) {
            $formParams['unsubscribe_notification_email'] = $list->unsubsribeNotificationEmail;
        }

        return $formParams;
    }
}
