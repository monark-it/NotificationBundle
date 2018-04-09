<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Tests\Sender;

use MIT\Bundle\NotificationBundle\Exception\NotSupportedChannel;
use MIT\Bundle\NotificationBundle\Notification\Notification;
use MIT\Bundle\NotificationBundle\Sender\DriverInterface;
use MIT\Bundle\NotificationBundle\Sender\NotificationSender;
use MIT\Bundle\NotificationBundle\Utils\NotificationUtils;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NotificationSenderTest extends WebTestCase
{
    /**
     * @var NotificationSender
     */
    private $ns;

    public function setUp()
    {
        self::bootKernel();
        $this->ns = static::$kernel->getContainer()
            ->get('mit_notification.notification_sender');
    }

    public function testDriver()
    {
        foreach (NotificationUtils::supportedChannels as $channel){
            $this->assertInstanceOf(DriverInterface::class, $this->ns->driver($channel));
        }

        $this->expectException(NotSupportedChannel::class);
        $this->ns->driver('fdsifjsdok');
    }

    public function testSendNow()
    {
        $notification = new Notification();

        $notification->setChannels([]);
        $this->assertSame([], $this->ns->sendNow($notification));

        $notification->setChannels(['mail' => 'dummy@test.nt']);
        $this->assertSame(['mail' => 'dummy@test.nt'], $this->ns->sendNow($notification));
    }
}
