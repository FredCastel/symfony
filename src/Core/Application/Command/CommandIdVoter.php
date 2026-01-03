<?php
namespace Core\Application\Command;
use Core\Application\Message\InformationMessage;
use Core\Application\Response\Notification;

abstract class CommandIdVoter implements CommandVoter
{
    /**
     * Summary of voter
     * @param \Core\Application\Command\CommandRequest $command
     * @return void
     * @throws CommandVoterException
     */

    public function vote(CommandRequest $command): void
    {
        if (property_exists($command, 'id')) {
            $this->voteFromId($command->id);
        } else {
            throw new \Exception("Command Id voter but command has no id", 1);
        }
    }

    public function voteFromId(?string $id): void
    {
        //id is require
        if ($id === null) {
            $notif = new Notification();
            $commandName = $this->listenTo();
            $notif->addMessage(new InformationMessage($commandName, "Command can't be applied without id"));
            throw new CommandVoterException($notif);
        }

        $this->internalVoter($id);
    }

    protected abstract function internalVoter(?string $id): void;

}