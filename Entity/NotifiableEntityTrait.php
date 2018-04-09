<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MIT\Bundle\NotificationBundle\Notification\Notifiable;

trait NotifiableEntityTrait
{
    use Notifiable;

    /**
     * @var NotificationCenter
     * @ORM\OneToOne(targetEntity="MIT\Bundle\NotificationBundle\Entity\NotificationCenter", cascade={"persist"})
     */
    protected $notificationCenter;

    /**
     * @return NotificationCenter
     */
    public function getNotificationCenter()
    {
        return $this->notificationCenter;
    }

    /**
     * @param NotificationCenter $notificationCenter
     * @return NotifiableEntityTrait
     */
    public function setNotificationCenter($notificationCenter)
    {
        $this->notificationCenter = $notificationCenter;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return NotifiableEntityTrait
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function notifications()
    {
        return $this->notificationCenter
            ? $this->notificationCenter->getNotifications()->toArray()
            : []
        ;
    }

    public function unReadNotifications()
    {
        return array_filter($this->notifications(), function(Notification $notification){
            return $notification->getReadAt() === null;
        });
    }
}