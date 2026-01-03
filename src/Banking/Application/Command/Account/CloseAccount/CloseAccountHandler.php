<?php

namespace Banking\Application\Command\Account\CloseAccount;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Application\Command\CommandHandler;

final class CloseAccountHandler extends AbstractCloseAccountHandler implements CommandHandler
{
    protected function check(
        AccountAggregate $aggregate,
        CloseAccountRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        AccountAggregate $aggregate,
        CloseAccountRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Close(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
