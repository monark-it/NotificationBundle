<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Events;

use Symfony\Component\EventDispatcher\Event;

class NotificationSentEvent extends Event
{
    const name = 'mit_notification.notification_sent';

    private $notification;

    /**
     * NotificationSentEvent constructor.
     * @param $notification
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return mixed
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param mixed $notification
     * @return NotificationSentEvent
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
        return $this;
    }
}