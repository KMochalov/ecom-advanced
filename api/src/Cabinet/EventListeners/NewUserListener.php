<?php

namespace App\Cabinet\EventListeners;

use App\Auth\Events\NewUserEvent;
use App\Cabinet\Command\CreateProfile\Handler;
use App\Cabinet\Command\CreateProfile\Command;

class NewUserListener
{
    public function __construct(private Handler $handler)
    {

    }
    public function __invoke(NewUserEvent $event): void
    {
        $command = new Command($event->getUserId()->getValue(), $event->getUserEmail()->getValue());
        $this->handler->handle($command);
    }
}
