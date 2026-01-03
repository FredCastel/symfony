<?php

namespace Banking\Application\Command\Bank\EnableBank;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Core\Application\Command\CommandHandler;

final class EnableBankHandler extends AbstractEnableBankHandler implements CommandHandler
{
    protected function check(
        BankAggregate $aggregate,
        EnableBankRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        BankAggregate $aggregate,
        EnableBankRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Enable(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
