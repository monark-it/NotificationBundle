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

use MIT\Bundle\NotificationBundle\Exception\NotSupportedChannel;
use MIT\Bundle\NotificationBundle\Utils\NotificationUtils;

class Notification
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var NotifiableInterface
     */
    protected $notifiable;

    /**
     * @var array
     */
    protected $channels = ['mail'];

    /**
     * @return string
     */
    public function smsMessage()
    {
        return $this->message;
    }

    /**
     * @return string | \Swift_Message
     */
    public function mailMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function dbMessage()
    {
        return $this->message;
    }

    /**
     * @param array $channels
     * @return $this
     */
    public function via(array $channels)
    {
        $this->channels = $channels;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return array
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * @param array $channels
     * @return Notification
     */
    public function setChannels($channels)
    {
        $this->channels = $channels;
        return $this;
    }

    /**
     * @return NotifiableInterface
     */
    public function getNotifiable()
    {
        return $this->notifiable;
    }

    /**
     * @param NotifiableInterface $notifiable
     * @return Notification
     */
    public function setNotifiable($notifiable)
    {
        $this->notifiable = $notifiable;
        return $this;
    }

    public function addChannel($channelName, $value=null)
    {
        if (in_array($channelName, NotificationUtils::supportedChannels, true)){
            $this->channels[$channelName]=$value;
        }
        else {
            throw new NotSupportedChannel();
        }
        return $this;
    }
}
