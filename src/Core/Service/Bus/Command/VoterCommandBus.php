<?php

namespace Core\Service\Bus\Command;

use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Application\Command\CommandVoter;
use Core\Application\Command\CommandVoterException;
use Core\Service\Bus\Command\CommandBus;
use Core\Service\Bus\Command\CommandBusMiddleware;

class VoterCommandBus implements CommandBusMiddleware
{
    private iterable $voters;

    public function __construct(
        private CommandBus $next,
        iterable $voters
    ) {
        $this->voters = [];
        foreach ($voters as $value) {
            /** @var CommandVoter */
            $voter = $value;
            $this->voters[$voter->listenTo()] = $voter;
        }
    }

    public function dispatch(CommandRequest $command): CommandResponse
    {
        $commandClass = get_class($command);
        if (array_key_exists($commandClass, $this->voters)) {
            /** @var CommandVoter */
            $voter = $this->voters[$commandClass];
            //validate commande
            $voter->vote($command);
        } else {
            //no error voter in not mandatory on command for the moment
        }

        return $this->next->dispatch($command);
    }
}