<?php

namespace Cluster\Application\Command\Party\Rename;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Core\Application\Command\CommandHandler;

final class RenameHandler extends AbstractRenameHandler implements CommandHandler
{
    protected function check(
        PartyAggregate $aggregate,
        RenameRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        PartyAggregate $aggregate,
        RenameRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Rename(
            entity_id: $command->entity_id,
            name: $command->name,
        );

        return [$aggregate, $events];
    }
}
