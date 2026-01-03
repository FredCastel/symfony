<?php

namespace Core\Service\Bus\Event;

use Core\Application\Event\EventHandler;
use Core\Domain\Event\Event;

class DispatcherEventBus implements EventBus
{
    private iterable $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = [];
        foreach ($handlers as $value) {
            /** @var EventHandler */
            $handler = $value;
            foreach ($handler->listenTo() as $event) {
                //multiple handlers allowed for an event
                if (!array_key_exists($event, $this->handlers)) {
                    $this->handlers[$event] = [];//handlers is an array
                }
                $this->handlers[$event][] = $handler;
            }

        }
    }

    public function dispatch(Event $event): void
    {
        $eventClass = get_class($event);
        foreach ($this->handlers as $key => $handlers) {
            if ($key == $eventClass) {
                foreach ($handlers as $handler) {//handlers is an array
                    $handler->handle($event);
                }
            }
        }
    }
}