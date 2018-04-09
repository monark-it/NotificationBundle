<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Notifier;

use MIT\Bundle\NotificationBundle\Events\NotificationSentEvent;
use MIT\Bundle\NotificationBundle\Exception\NotSupportedChannel;
use MIT\Bundle\NotificationBundle\Notification\NotifiableInterface;
use MIT\Bundle\NotificationBundle\Notification\Notification;
use MIT\Bundle\NotificationBundle\Sender\NotificationSenderInterface;
use MIT\Bundle\NotificationBundle\Utils\NotificationUtils;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Notifier implements NotifierInterface
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var NotificationSenderInterface
     */
    private $notificationSender;

    /**
     * Notifier constructor.
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @param NotificationSenderInterface $notificationSender
     */
    public function __construct($eventDispatcher, $notificationSender)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->notificationSender = $notificationSender;
    }

    public function notify($notifiable, $notification, $channels = ['mail'])
    {
        if(is_array($notifiable)){
            foreach ($notifiable as $item) {
                $this->notifyToNotifiable($item, $notification, $channels);
            }
        }else{
            $this->notifyToNotifiable($notifiable, $notification, $channels);
        }
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @return Notifier
     */
    public function setEventDispatcher($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        return $this;
    }

    /**
     * @return NotificationSenderInterface
     */
    public function getNotificationSender()
    {
        return $this->notificationSender;
    }

    /**
     * @param NotificationSenderInterface $notificationSender
     * @return Notifier
     */
    public function setNotificationSender($notificationSender)
    {
        $this->notificationSender = $notificationSender;
        return $this;
    }

    public function channel($channel)
    {
        if(!in_array($channel, NotificationUtils::supportedChannels, true)) throw new NotSupportedChannel();
        return $this->notificationSender->driver($channel);
    }

    /**
     * @param NotifiableInterface $notifiable
     * @param Notification $notification
     * @param array $channels
     * @return mixed
     */
    protected function notifyToNotifiable($notifiable, $notification, $channels = ['mail'])
    {
        $notification = $notifiable->notify($notification->setChannels($channels));
        $this->getNotificationSender()->send($notification);
        $this->eventDispatcher->dispatch(NotificationSentEvent::name, new NotificationSentEvent($notification));
    }
}
