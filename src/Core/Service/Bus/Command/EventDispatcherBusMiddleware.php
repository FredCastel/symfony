<?php

namespace Core\Service\Bus\Command;

use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Application\Command\CommandValidator;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\Bus\Command\CommandBusMiddleware;
use Core\Service\Bus\Event\EventBus;

class EventDispatcherBusMiddleware implements CommandBusMiddleware
{
    private iterable $validators;

    public function __construct(
        private CommandBus $next,
        private EventBus $eventBus,
    ) {
    }

    public function dispatch(CommandRequest $command): CommandResponse
    {
        $response = $this->next->dispatch($command);
        foreach ($response->events() as $event) {
            $this->eventBus->dispatch($event);
        }

        return $response;
    }
}