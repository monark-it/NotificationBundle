<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Sender\Driver;

use Doctrine\ORM\EntityManagerInterface;
use MIT\Bundle\NotificationBundle\Entity\NotifiableEntityTrait;
use MIT\Bundle\NotificationBundle\Entity\Notification as EntityNotification;
use MIT\Bundle\NotificationBundle\Entity\NotificationCenter;
use MIT\Bundle\NotificationBundle\Notification\NotifiableInterface;
use MIT\Bundle\NotificationBundle\Notification\Notification;
use MIT\Bundle\NotificationBundle\Sender\DriverInterface;

class Database implements DriverInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Database constructor.
     *
     * @param $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * @param Notification $notification
     * @return Notification
     */
    public function handle($notification)
    {
        $this->em->persist($this->createDatabaseNotification($notification));
        $this->em->flush();
        return $notification;
    }

    /**
     * @param EntityNotification $notification
     */
    public function remove(EntityNotification $notification)
    {
        $this->em->remove($notification);
        $this->em->flush();
    }

    /**
     * @param EntityNotification $notification
     * @param string $readAt
     */
    public function markAsRead(EntityNotification $notification, $readAt="now")
    {
        if("now" === $readAt) $readAt= new \DateTime();
        $notification->setReadAt($readAt);
        $this->em->flush();

        if($notification->getDeleteOnRead()){
            $this->remove($notification);
        }
    }

    /**
     * @param array $notifications
     * @param string $readAt
     */
    public function markAllAsRead(array $notifications, $readAt="now")
    {
        if("now" === $readAt) $readAt= new \DateTime();
        foreach ($notifications as $notification) {
            $this->markAsRead($notification, $readAt);
        }
    }

    private function createDatabaseNotification(Notification $notification)
    {
        $entity = new EntityNotification();
        $entity
            ->setMessage($notification->dbMessage())
        ;
        if(null !== $ne=$this->notifiableEntity($notification->getNotifiable()))
        {
            $entity->setNotificationCenter($this->nc($ne));
        }
        return $entity;
    }

    /**
     * @param $notifiable
     * @return null|NotifiableEntityTrait
     */
    private function notifiableEntity($notifiable)
    {
        $class = $this->em->getClassMetadata(get_class($notifiable))->getName();
        $repository = $this->em->getRepository($class);
        return method_exists($notifiable, 'getId') ? $repository->find($notifiable->getId()) : null;
    }

    /**
     * @param NotifiableEntityTrait $entityNotifiable
     * @return NotificationCenter
     */
    private function nc($entityNotifiable)
    {
        if(null === $nc=$entityNotifiable->getNotificationCenter()){
            $nc = new NotificationCenter();
            $this->em->persist($nc);
            $entityNotifiable->setNotificationCenter($nc);
            $this->em->flush();
        }
        return $nc;
    }
}
