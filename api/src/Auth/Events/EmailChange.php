<?php

namespace App\Auth\Events;

use App\Entity\Id;
use App\Entity\Email;
use Symfony\Contracts\EventDispatcher\Event;

class EmailChange extends Event
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