<?php

namespace Banking\Application\Command\Account\SetAccountInitialBalance;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Application\Command\CommandHandler;

final class SetAccountInitialBalanceHandler extends AbstractSetAccountInitialBalanceHandler implements CommandHandler
{
    protected function check(
        AccountAggregate $aggregate,
        SetAccountInitialBalanceRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        AccountAggregate $aggregate,
        SetAccountInitialBalanceRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->SetInitialBalance(
            entity_id: $command->entity_id,
            balance: $command->balance,
        );

        return [$aggregate, $events];
    }
}
