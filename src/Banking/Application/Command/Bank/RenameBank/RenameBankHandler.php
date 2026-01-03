<?php

namespace Banking\Application\Command\Bank\RenameBank;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Core\Application\Command\CommandHandler;

final class RenameBankHandler extends AbstractRenameBankHandler implements CommandHandler
{
    protected function check(
        BankAggregate $aggregate,
        RenameBankRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        BankAggregate $aggregate,
        RenameBankRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Change(
            entity_id: $command->entity_id,
            name: $command->name,
            url: $command->url,
            bic: $command->bic,
        );

        return [$aggregate, $events];
    }
}
