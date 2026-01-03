<?php

namespace Core\Service\Bus\Command;

use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandResponse;

class DispatcherCommandBus implements CommandBusMiddleware
{
    private iterable $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = [];
        foreach ($handlers as $value) {
            /** @var CommandHandler */
            $handler = $value;
            $this->handlers[$handler->listenTo()] = $handler;
        }
    }

    public function dispatch(CommandRequest $command): CommandResponse
    {
        $commandClass = get_class($command);
        if (!array_key_exists($commandClass, $this->handlers))
            throw new \LogicException("Handler for command $commandClass not found");
        /** @var CommandHandler */
        $handler = $this->handlers[$commandClass];

        return $handler->execute($command);
    }
}