<?php

namespace Core\Application\Command;

interface CommandHandler
{
    public function listenTo(): string;
    public function execute(CommandRequest $command): CommandResponse;
}