<?php

namespace Cluster\Application\Command\Party\Remove;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Core\Application\Command\CommandHandler;

final class RemoveHandler extends AbstractRemoveHandler implements CommandHandler
{
    protected function check(
        PartyAggregate $aggregate,
        RemoveRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        PartyAggregate $aggregate,
        RemoveRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Remove(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
