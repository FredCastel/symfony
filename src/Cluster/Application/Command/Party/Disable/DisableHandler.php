<?php

namespace Cluster\Application\Command\Party\Disable;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Core\Application\Command\CommandHandler;

final class DisableHandler extends AbstractDisableHandler implements CommandHandler
{
    protected function check(
        PartyAggregate $aggregate,
        DisableRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        PartyAggregate $aggregate,
        DisableRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Disable(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
