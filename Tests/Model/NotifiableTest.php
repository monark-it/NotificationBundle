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

class NotifiableTest extends \PHPUnit_Framework_TestCase
{
    public function testNotify()
    {
        $notifiable = $this->getNotifiable();

        $this->assertTrue(method_exists($notifiable, 'getMobilePhoneNumber'));
        $this->assertTrue(method_exists($notifiable, 'getEmail'));

        $notifiable->setPhoneNumber('06125245');
        $notification = $this->getNotification();
        $notifiable->notify($notification);

        //$this->assertSame(['sms' => '06125245', 'mail' => 'dummy@dummy.dummy', 'database'=> true], $notification->getChannels());
        $this->assertSame('06125245', $notification->getChannels()['sms']);
        $this->assertSame(DummyNotifiable::FAKE_EMAIL, $notification->getChannels()['mail']);
        $this->assertSame(true, $notification->getChannels()['database']);

        $notification->setChannels(['sms']);
        $notifiable->notify($notification);
        $this->assertSame(['sms' => '06125245'], $notification->getChannels());

        $notification->setChannels(['mail']);
        $notifiable->notify($notification);
        $this->assertSame(['mail' => 'dummy@dummy.dummy'], $notification->getChannels());

        $notification->setChannels(['database']);
        $notifiable->notify($notification);
        $this->assertSame(['database' => true], $notification->getChannels());
    }

    public function testPhoneNumber()
    {
        $notifiable = $this->getNotifiable();
        $this->assertSame(DummyNotifiable::FAKE_PHONE_NUMBER, $notifiable->getPhoneNumber());

        $notifiable->setPhoneNumber('06125247');
        $this->assertSame('06125247', $notifiable->getPhoneNumber());
    }

    public function getNotification()
    {
        return (new DummyNotification())->setChannels(['mail', 'sms', 'database']);
    }

    public function getNotifiable()
    {
        return new DummyNotifiable();
    }
}

class DummyNotifiable implements NotifiableInterface
{
    use NotifiableEntityTrait;
    const FAKE_EMAIL = 'dummy@dummy.dummy';
    const FAKE_PHONE_NUMBER = '06125247';

    protected $phoneNumber = self::FAKE_PHONE_NUMBER;

    /**
     * Your notifiable should implements this method in order to receive notifications via the 'mail' channel.
     *
     * @return string
     */
    public function getEmail()
    {
        return self::FAKE_EMAIL;
    }
}