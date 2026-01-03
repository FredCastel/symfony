<?php

namespace Core\Service\Bus\Event;

use Core\Service\Bus\Event\EventBus;

class EventBusFactory
{
    static public function build(
        iterable $handlers,
    ): EventBus {

        //create each bus instance starting from the last
        $dispatcherBus = new DispatcherEventBus(
            handlers: $handlers
        );

        return $dispatcherBus;
    }
}