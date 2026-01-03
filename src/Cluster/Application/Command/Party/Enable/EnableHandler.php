<?php

namespace Cluster\Application\Command\Party\Enable;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Core\Application\Command\CommandHandler;

final class EnableHandler extends AbstractEnableHandler implements CommandHandler
{
    protected function check(
        PartyAggregate $aggregate,
        EnableRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        PartyAggregate $aggregate,
        EnableRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Enable(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
