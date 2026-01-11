<?php

namespace Banking\Application\Command\Bank\SetBankBic;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Core\Application\Command\CommandHandler;

final class SetBankBicHandler extends AbstractSetBankBicHandler implements CommandHandler
{
    protected function check(
        BankAggregate $aggregate,
        SetBankBicRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        BankAggregate $aggregate,
        SetBankBicRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Change(
            entity_id: $command->entity_id,
            url: null,
            bic: $command->bic,
        );

        return [$aggregate, $events];
    }
}
