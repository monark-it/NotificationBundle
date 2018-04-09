<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Tests\Model;

use MIT\Bundle\NotificationBundle\Entity\NotifiableEntityTrait;
use MIT\Bundle\NotificationBundle\Notification\NotifiableInterface;
use MIT\Bundle\NotificationBundle\Notification\Notification;

class NotificationTest extends \PHPUnit_Framework_TestCase
{
    public function testChannels()
    {
        $notification = $this->getNotification();

        $this->assertSame(['mail'], $notification->getChannels());
        $notification->setChannels(['sms', 'mail']);

        $this->assertSame(['sms', 'mail'], $notification->getChannels());
    }

    public function testVia()
    {
        $notification = $this->getNotification();

        $this->assertSame(['mail'], $notification->getChannels());
        $notification->via(['sms', 'mail']);

        $this->assertSame(['sms', 'mail'], $notification->getChannels());
    }

    public function testMessage()
    {
        $notification = $this->getNotification();

        $this->assertNull($notification->getMessage());
        $notification->setMessage("Hello NOtification");

        $this->assertSame("Hello NOtification", $notification->getMessage());
        $this->assertSame("Hello NOtification", $notification->smsMessage());
        $this->assertSame("Hello NOtification", $notification->mailMessage());
        $this->assertSame("Hello NOtification", $notification->dbMessage());
    }

    public function testNotifiable()
    {
        $notification = $this->getNotification();

        $this->assertNull($notification->getNotifiable());

        $notification->setNotifiable($this->getNotifiable());

        $this->assertInstanceOf(NotifiableInterface::class, $notification->getNotifiable());
    }

    public function getNotification()
    {
        return new DummyNotification();
    }

    public function getNotifiable()
    {
        return new DummyNotifiable();
    }
}

class DummyNotification extends Notification
{
}
