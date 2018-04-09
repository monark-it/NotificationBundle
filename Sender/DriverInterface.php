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

use MIT\Bundle\NotificationBundle\Notification\Notification;

interface DriverInterface
{
    /**
     * @param Notification $notification
     * @return mixed
     */
    public function handle($notification);
}