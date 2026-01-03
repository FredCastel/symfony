<?php

namespace Banking\Application\Command\Account\RemoveAccountOperation;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Application\Command\CommandHandler;

final class RemoveAccountOperationHandler extends AbstractRemoveAccountOperationHandler implements CommandHandler
{
    protected function check(
        AccountAggregate $aggregate,
        RemoveAccountOperationRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        AccountAggregate $aggregate,
        RemoveAccountOperationRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->RemoveOperation(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
