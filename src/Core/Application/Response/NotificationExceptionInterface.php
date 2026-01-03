<?php

namespace Core\Application\Response;

use Core\Application\Response\Notification;

interface NotificationExceptionInterface
{

    public function getNotification(): Notification;
}