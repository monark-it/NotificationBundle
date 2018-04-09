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

use GuzzleHttp\Psr7\Response;
use MIT\Bundle\NotificationBundle\Notification\Notification;
use MIT\Bundle\NotificationBundle\Sender\DriverInterface;
use Psr\Http\Message\ResponseInterface;

class Gammu implements DriverInterface
{
    private $host;

    private $email;

    private $password;

    /**
     * Gammu constructor.
     * @param $host
     * @param $email
     * @param $password
     */
    public function __construct($host, $email, $password)
    {
        $this->host = $host;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @param Notification $notification
     * @return boolean | ResponseInterface
     */
    public function handle($notification)
    {
        $phoneNumber = $notification->getChannels()['sms'];
        $smsMessage = $notification->smsMessage();

        return class_exists(\GuzzleHttp\Client::class)
            ? $this->sendWithGuzzle($phoneNumber, $smsMessage)
            : $this->sendWithCurl($phoneNumber, $smsMessage);
    }

    private function sendWithGuzzle($phoneNumber, $smsMessage)
    {
        $url = $this->host.'/RaspiSMS/smsAPI/';
        $client = new \GuzzleHttp\Client();

        $res = $client->request('GET', $url, [
            'query' => [
                'email' => $this->email,
                'password' => $this->password,
                'numbers[]' => $phoneNumber,
                'text' => $smsMessage
            ]
        ]);

        return $res;
    }

    private function sendWithCurl($phoneNumber, $smsMessage)
    {
        $url = $this->host.'/RaspiSMS/smsAPI/?email='.$this->email
            .'&password='.$this->password
            .'&numbers[]='.$phoneNumber
            .'&text='.$smsMessage
        ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, urlencode($url));
        if( false === $result = curl_exec($ch))
        {
            throw new \Exception(@trigger_error(curl_error($ch)));
        }
        curl_close($ch);
        return $result;
    }
}
