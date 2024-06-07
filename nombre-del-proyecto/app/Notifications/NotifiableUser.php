<?php

namespace App\Notifications;

use Illuminate\Notifications\Notifiable;

class NotifiableUser
{
    use Notifiable;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
