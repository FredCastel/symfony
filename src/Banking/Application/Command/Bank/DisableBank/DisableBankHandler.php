<?php

namespace Banking\Application\Command\Bank\DisableBank;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Core\Application\Command\CommandHandler;

final class DisableBankHandler extends AbstractDisableBankHandler implements CommandHandler
{
    protected function check(
        BankAggregate $aggregate,
        DisableBankRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        BankAggregate $aggregate,
        DisableBankRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Disable(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
