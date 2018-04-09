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

/**
 * NotificationCenter
 *
 * @ORM\Table(name="mit_notifications_notification_center")
 * @ORM\Entity(repositoryClass="MIT\Bundle\NotificationBundle\Repository\NotificationCenterRepository")
 */
class NotificationCenter
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *      targetEntity="MIT\Bundle\NotificationBundle\Entity\Notification",
     *      mappedBy="notificationCenter"
     * )
     */
    private $notifications;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->notifications = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add notification
     *
     * @param \MIT\Bundle\NotificationBundle\Entity\Notification $notification
     *
     * @return NotificationCenter
     */
    public function addNotification(\MIT\Bundle\NotificationBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification
     *
     * @param \MIT\Bundle\NotificationBundle\Entity\Notification $notification
     */
    public function removeNotification(\MIT\Bundle\NotificationBundle\Entity\Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }
}
