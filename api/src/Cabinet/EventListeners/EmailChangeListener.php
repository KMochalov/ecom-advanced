<?php

namespace App\Cabinet\EventListeners;

use App\Auth\Events\EmailChange;
use App\Cabinet\Command\ChangeEmail\Handler;
use App\Cabinet\Command\ChangeEmail\Command;

class EmailChangeListener
{
    public function __construct(private Handler $handler)
    {

    }
    public function __invoke(EmailChange $event): void
    {
        $command = new Command($event->getUserId(), $event->getUserEmail());
        $this->handler->handle($command);
    }
}