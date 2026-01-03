<?php

namespace Banking\Application\Command\Account\RenameAccount;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Application\Command\CommandHandler;

final class RenameAccountHandler extends AbstractRenameAccountHandler implements CommandHandler
{
    protected function check(
        AccountAggregate $aggregate,
        RenameAccountRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        AccountAggregate $aggregate,
        RenameAccountRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Change(
            entity_id: $command->entity_id,
            name: $command->name,
        );

        return [$aggregate, $events];
    }
}
