<?php

namespace Core\Service\Bus\Command;

use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Application\Command\CommandValidator;
use Core\Application\Command\CommandValidatorException;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\Bus\Command\CommandBusMiddleware;

class ValidatorCommandBus implements CommandBusMiddleware
{
    private iterable $validators;

    public function __construct(
        private CommandBus $next,
        iterable $validators
    ) {
        $this->validators = [];
        foreach ($validators as $value) {
            /** @var CommandValidator */
            $validator = $value;
            $this->validators[$validator->listenTo()] = $validator;
        }
    }

    public function dispatch(CommandRequest $command): CommandResponse
    {
        $commandClass = get_class($command);
        if (array_key_exists($commandClass, $this->validators)) {
            /** @var CommandValidator */
            $validator = $this->validators[$commandClass];
            //validate commande
            $validator->validate($command);
        } else {
            //no error validator in not mandatory on command for the moment
        }

        return $this->next->dispatch($command);
    }
}