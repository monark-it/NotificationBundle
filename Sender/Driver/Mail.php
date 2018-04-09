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

use MIT\Bundle\NotificationBundle\Notification\Notification;
use MIT\Bundle\NotificationBundle\Sender\DriverInterface;
use Symfony\Component\VarDumper\VarDumper;

class Mail implements DriverInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    private $params;

    /**
     * Mail constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->params = [
            'from' => "tes@metes.ed"
        ];
    }

    /**
     * @return \Swift_Mailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * @param \Swift_Mailer $mailer
     * @return Mail
     */
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;
        return $this;
    }

    public function handle($notification)
    {
        $to = $notification->getChannels()['mail'];

        return $this->sendEmailMessage($to, $this->params["from"], $notification->mailMessage());
    }

    /**
     * @param string $to
     * @param string $from
     * @param string|\Swift_Message $body
     * @return int
     */
    private function sendEmailMessage($to, $from, $body)
    {
        $message = $body instanceof \Swift_Message
            ? clone $body
            : \Swift_Message::newInstance()->setBody($body);

        $message->setTo($to)->setFrom($from);
        return $this->mailer->send($message);
    }
}