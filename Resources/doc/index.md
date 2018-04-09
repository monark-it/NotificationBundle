Usage
1. Create a notification class

```php
use MIT\Bundle\NotificationBundle\Notification\Notification;
use MIT\Bundle\UserBundle\Entity\User;

class NewUser extends Notification
{
    /**
     * @var User
     */
    private $user;

    /**
     * NewUser constructor.
     */
    public function __construct($user)
    {
        $this->user = $user;

        $this->message = 'This is the content of a message. Username: '.$this->user->getUsername();
    }

    public function mailMessage()
    {
        $subject = 'MIT Platform - A new user has been added';
        return $mailMessage = \Swift_Message::newInstance($subject, $this->getMessage());
    }
}
```
2. Prepare your notifiable
Your notifiable class should implement the NotifiableInterface. You can use the NotifiableEntityTrait by default.

3. Notify your notifiable.

```php
$notifier = $this->container->get('mit_notification.notifier');
$notifier->notify($administrator, new NewUser());
```
You can also specify the channels. By default, only the mail channel is used.
```php
$notifier = $this->container->get('mit_notification.notifier');
$notifier->notify($administrator, new NewUser(), ['mail', 'sms', 'database']);
```