<?php

namespace Core\Service\Bus\Command;

use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;

interface CommandBus
{
    public function dispatch(CommandRequest $command): CommandResponse;
}