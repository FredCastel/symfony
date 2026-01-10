<?php

namespace Cluster\Application\Command\Party\RegisterNatural;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Cluster\Domain\ValueObject\PartyCategory;
use Cluster\Domain\ValueObject\PartyState;
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
        [$aggregate, $events] = (new PartyAggregate(new Id($command->id)))->getRoot()->register(
            entity_id: $command->entity_id,
            name: $command->name,
            state: PartyState::ENABLED,// mapping rule
            category: PartyCategory::NATURAL,// mapping rule
            validSince: null,
            validUntil: null,
            url: null,
            image: null,
        );

        return [$aggregate, $events];
    }
}
