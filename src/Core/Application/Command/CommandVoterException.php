<?php

namespace Core\Application\Command;

use Core\Application\Response\Notification;
use Core\Application\Response\NotificationExceptionInterface;

class CommandVoterException extends \Exception implements NotificationExceptionInterface
{
    public function __construct(
        protected Notification $notification
    ) {
    }

    public function getNotification(): Notification
    {
        return $this->notification;
    }
}