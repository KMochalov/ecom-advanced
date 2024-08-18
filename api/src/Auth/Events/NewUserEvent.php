<?php

namespace App\Auth\Events;

use App\Auth\Entity\User\Id;
use Symfony\Contracts\EventDispatcher\Event;

class NewUserEvent extends Event
{
    public function __construct(private Id $userId)
    {
    }

    public function getUserId(): Id
    {
        return $this->userId;
    }
}