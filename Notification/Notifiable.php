<?php

/*
 * This file is part of the MIT Platform Project.
 *
 * (c) Multi Information Technology <http://www.mit.co.ma>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MIT\Bundle\NotificationBundle\Notification;

trait Notifiable
{
    /**
     * Manages notification for this notifiable. By default it attaches informations to its channel.
     *
     * @param Notification $notification
     * @return Notification
     */
    public function notify($notification)
    {
        $channels = [];
        foreach ($notification->getChannels() as $channel) {
            $notification->setNotifiable($this);
            switch($channel){
                case 'sms':
                    if(method_exists($this, 'getMobilePhoneNumber'))$channels[$channel] = $this->getMobilePhoneNumber();
                    else throw new \InvalidArgumentException(sprintf("This Notifiable should have 'getMobilePhoneNumber' method if you want use %s channel.", $channel));
                    break;
                case 'mail':
                    if(method_exists($this, 'getEmail')) $channels[$channel] = $this->getEmail();
                    else throw new \InvalidArgumentException(sprintf("This Notifiable should have 'getEmail' method if you want use %s channel.", $channel));
                    break;
                case 'database':
                    $channels[$channel] = true;
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf("Channel %s not supported. Channel should one of 'mail', 'sms' or 'database'.", $channel));
            }
        }
        return $notification->setChannels($channels);
    }

    public function getMobilePhoneNumber()
    {
        return $this->phoneNumber;
    }
}
