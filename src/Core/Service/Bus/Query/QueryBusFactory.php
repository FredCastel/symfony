<?php

namespace Core\Service\Bus\Query;

class QueryBusFactory
{
    static public function build(
        iterable $handlers,
    ): QueryBus {

        //create each bus instance starting from the last
        $dispatcherBus = new DispatcherQueryBus(
            handlers: $handlers
        );

        return $dispatcherBus;
    }
}