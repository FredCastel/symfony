<?php

namespace Core\Application\Event;

use Core\Domain\Event\AbstractEvent;

interface EventHandler
{
    public function listenTo(): iterable;
    public function handle(AbstractEvent $event): void;
}