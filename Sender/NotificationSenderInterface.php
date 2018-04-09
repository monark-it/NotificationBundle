<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Sender;

use MIT\Bundle\NotificationBundle\Notification\NotifiableInterface;
use MIT\Bundle\NotificationBundle\Notification\Notification;

interface NotificationSenderInterface
{
    /**
     * @param Notification $notification
     * @return mixed
     */
    public function send($notification);

    /**
     * @param Notification $notification
     * @return mixed
     */
    public function sendNow($notification);

    /**
     * @param string $channelName
     * @return DriverInterface | null
     */
    public function driver($channelName);
}