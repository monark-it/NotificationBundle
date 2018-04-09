<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Utils;

final class NotificationUtils
{
    /**
     * For now only 3 channels are supported for notification. Notifications via WebHooks could be added later.
     */
    const supportedChannels = ['mail', 'sms', 'database'];
}