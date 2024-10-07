<?php

namespace App\Auth\Events;

use App\Auth\Entity\User\Id;
use App\Entity\Email;
use Symfony\Contracts\EventDispatcher\Event;

class NewUserEvent extends Event
{
    public function __construct(private Id $userId, private Email $email)
    {
    }

    public function getUserId(): Id
    {
        return $this->userId;
    }

    public function getUserEmail(): Email
    {
        return $this->email;
    }
}
