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

/**
 * The Notifier is responsible of notifying the notifiables via channels.
 *
 * Interface NotifierInterface
 * @package MIT\Bundle\NotificationBundle\Contracts
 */
interface NotifierInterface
{
    /**
     * @param NotifiableInterface | array $notifiable
     * @param Notification $notification
     * @param array $channels
     * @return mixed
     */
    public function notify($notifiable, $notification, $channels = ['mail']);

    /**
     * Returns the channel manager of the specified channel. If you specify 'database' for example, you'll
     * have access to the database notification sender so you can execute actions specific to this channel like
     * removing notification, mark notification as read...
     *
     * Example:
     *      $notifier->channel('database')->markAsRead($entityNotification); // OK
     *      $notifier->channel('mail')->markAsRead($notification); // ERROR
     *
     * @param string $channel The channel name ('sms', 'mail', 'database').
     * @return mixed
     */
    public function channel($channel);
}