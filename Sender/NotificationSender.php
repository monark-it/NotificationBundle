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

use MIT\Bundle\NotificationBundle\Exception\NotSupportedChannel;
use MIT\Bundle\NotificationBundle\Notification\Notification;
use MIT\Bundle\NotificationBundle\Utils\NotificationUtils;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NotificationSender implements NotificationSenderInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected $driver;

    protected $channel = "";

    /**
     * NotificationSender constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function send($notification)
    {
        return $this->sendNow($notification);
    }

    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    public function sendNow($notification)
    {
        $channels = $notification->getChannels();
        foreach (array_keys($channels) as $key) {
            $this->drivers()[$key]->handle($notification);
        }
        return $channels;
    }

    /**
     * @param string $channelName
     * @throws NotSupportedChannel
     * @return mixed
     */
    public function driver($channelName)
    {
        if (!in_array($channelName, NotificationUtils::supportedChannels, true)) throw new NotSupportedChannel();
        return $this->drivers()[$channelName];
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

    private function drivers()
    {
        return [
            'mail' => $this->getContainer()->get('mit_notification.mail_driver'),
            'sms' => $this->getContainer()->get('mit_notification.sms_driver'),
            'database' => $this->getContainer()->get('mit_notification.database_driver')
        ];
    }
}