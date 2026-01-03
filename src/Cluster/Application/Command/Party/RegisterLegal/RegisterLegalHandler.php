<?php

namespace Cluster\Application\Command\Party\RegisterLegal;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Core\Application\Command\CommandHandler;
use Core\Domain\ValueObject\Id;

final class RegisterLegalHandler extends AbstractRegisterLegalHandler implements CommandHandler
{
    protected function check(
        RegisterLegalRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        RegisterLegalRequest $command,
    ): array {
        [$aggregate, $events] = (new PartyAggregate(new Id($command->id)))->getRoot()->Register(
            entity_id: $command->entity_id,
            name: $command->name,
            state: 'todo',// TODO mapping rule
            category: 'todo',// TODO mapping rule
            url: $command->url,
            address: $command->address,
            image: null,
        );

        return [$aggregate, $events];
    }
}
