<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Contracts;

use MIT\Bundle\NotificationBundle\Notification\Notification;

interface NotifiableInterface
{
    /**
     * @param Notification $notification
     * @return Notification
     */
    public function notify($notification);

    /**
     * Your notifiable should implements this method in order to receive notifications via the 'sms' channel.
     *
     * @return string
     */
    public function getMobilePhoneNumber();

    /**
     * Your notifiable should implements this method in order to receive notifications via the 'mail' channel.
     *
     * @return string
     */
    public function getEmail();
}