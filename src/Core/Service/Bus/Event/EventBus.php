<?php

namespace Core\Service\Bus\Event;

use Core\Domain\Event\Event;

interface EventBus
{
    public function dispatch(Event $event): void;
}