<?php

namespace Cluster\Application\Command\Party\RegisterLegal;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Cluster\Domain\ValueObject\PartyCategory;
use Cluster\Domain\ValueObject\PartyState;
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
        [$aggregate, $events] = (new PartyAggregate(new Id($command->id)))->getRoot()->register(
            entity_id: $command->entity_id,
            name: $command->name,
            state: PartyState::ENABLED,
            category: PartyCategory::NATURAL,
            url: $command->url,
        );

        return [$aggregate, $events];
    }
}
