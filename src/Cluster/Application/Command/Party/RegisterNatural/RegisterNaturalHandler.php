<?php

namespace Cluster\Application\Command\Party\RegisterNatural;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Core\Application\Command\CommandHandler;
use Core\Domain\ValueObject\Id;

final class RegisterNaturalHandler extends AbstractRegisterNaturalHandler implements CommandHandler
{
    protected function check(
        RegisterNaturalRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        RegisterNaturalRequest $command,
    ): array {
        [$aggregate, $events] = (new PartyAggregate(new Id($command->id)))->getRoot()->Register(
            entity_id: $command->entity_id,
            name: $command->name,
            state: 'todo',// TODO mapping rule
            category: 'todo',// TODO mapping rule
            url: null,
            address: $command->address,
            image: null,
        );

        return [$aggregate, $events];
    }
}
