<?php

namespace Banking\Application\Command\Account\OpenAccount;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Application\Command\CommandHandler;

final class OpenAccountHandler extends AbstractOpenAccountHandler implements CommandHandler
{
    protected function check(
        AccountAggregate $aggregate,
        OpenAccountRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        AccountAggregate $aggregate,
        OpenAccountRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Open(
            entity_id: $command->entity_id,
        );

        return [$aggregate, $events];
    }
}
