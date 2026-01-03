<?php

namespace Banking\Application\Command\Account\RemoveAccount;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Application\Command\CommandHandler;

final class RemoveAccountHandler extends AbstractRemoveAccountHandler implements CommandHandler
{
    protected function check(
        AccountAggregate $aggregate,
        RemoveAccountRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        AccountAggregate $aggregate,
        RemoveAccountRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Remove(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
