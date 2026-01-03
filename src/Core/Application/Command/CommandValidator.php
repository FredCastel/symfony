<?php
namespace Core\Application\Command;

use Core\Application\Response\Notification;

interface CommandValidator
{
    public function listenTo(): string;

    /**
     * Summary of validate
     * @param \Core\Application\Command\CommandRequest $command
     * @return void
     * @throws CommandValidatorException
     */
    public function validate(CommandRequest $command): void;

}