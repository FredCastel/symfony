<?php

namespace Banking\Application\Command\Bank\RemoveBank;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Core\Application\Command\CommandHandler;

final class RemoveBankHandler extends AbstractRemoveBankHandler implements CommandHandler
{
    protected function check(
        BankAggregate $aggregate,
        RemoveBankRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        BankAggregate $aggregate,
        RemoveBankRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Remove(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
