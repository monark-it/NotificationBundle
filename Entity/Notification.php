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

use Doctrine\ORM\Mapping as ORM;
use MIT\Bundle\NotificationBundle\Notification\NotifiableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Notification
 *
 * @ORM\Table(name="mit_notifications_notification")
 * @ORM\Entity(repositoryClass="MIT\Bundle\NotificationBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="read_at", type="datetime", nullable=true)
     * @Assert\DateTime
     */
    private $readAt;

    /**
     * @var NotificationCenter
     * @ORM\ManyToOne(
     *      targetEntity="MIT\Bundle\NotificationBundle\Entity\NotificationCenter",
     *      inversedBy="notifications"
     * )
     */
    private $notificationCenter;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $deleteOnRead=false;

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
     * Set message
     *
     * @param string $message
     *
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set readAt
     *
     * @param \DateTime $readAt
     *
     * @return Notification
     */
    public function setReadAt($readAt)
    {
        $this->readAt = $readAt;

        return $this;
    }

    /**
     * Get readAt
     *
     * @return \DateTime
     */
    public function getReadAt()
    {
        return $this->readAt;
    }

    /**
     * Set deleteOnRead
     *
     * @param boolean $deleteOnRead
     *
     * @return Notification
     */
    public function setDeleteOnRead($deleteOnRead)
    {
        $this->deleteOnRead = $deleteOnRead;

        return $this;
    }

    /**
     * Get deleteOnRead
     *
     * @return boolean
     */
    public function getDeleteOnRead()
    {
        return $this->deleteOnRead;
    }

    /**
     * Set notificationCenter
     *
     * @param \MIT\Bundle\NotificationBundle\Entity\NotificationCenter $notificationCenter
     *
     * @return Notification
     */
    public function setNotificationCenter(\MIT\Bundle\NotificationBundle\Entity\NotificationCenter $notificationCenter = null)
    {
        $this->notificationCenter = $notificationCenter;

        return $this;
    }

    /**
     * Get notificationCenter
     *
     * @return \MIT\Bundle\NotificationBundle\Entity\NotificationCenter
     */
    public function getNotificationCenter()
    {
        return $this->notificationCenter;
    }
}
