<?php
namespace Core\Application\Command;

interface CommandVoter
{
    public function listenTo(): string;

    /**
     * Summary of voter
     * @param \Core\Application\Command\CommandRequest $command
     * @return void
     * @throws CommandVoterException
     */
    public function vote(CommandRequest $command): void;
    public function voteFromId(?string $id): void;

}