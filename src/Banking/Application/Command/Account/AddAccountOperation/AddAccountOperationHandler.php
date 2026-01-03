<?php

namespace Banking\Application\Command\Account\AddAccountOperation;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Application\Command\CommandHandler;

final class AddAccountOperationHandler extends AbstractAddAccountOperationHandler implements CommandHandler
{
    protected function check(
        AccountAggregate $aggregate,
        AddAccountOperationRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        AccountAggregate $aggregate,
        AddAccountOperationRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->AddOperation(
            entity_id: $command->entity_id,
            label: $command->label,
            amount: $command->amount,
            valueDate: $command->valueDate,
            operationDate: $command->operationDate,
        );

        return [$aggregate, $events];
    }
}
