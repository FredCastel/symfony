<?php

namespace Banking\Application\Command\Account\SetAccountBalanceLimits;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Application\Command\CommandHandler;

final class SetAccountBalanceLimitsHandler extends AbstractSetAccountBalanceLimitsHandler implements CommandHandler
{
    protected function check(
        AccountAggregate $aggregate,
        SetAccountBalanceLimitsRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        AccountAggregate $aggregate,
        SetAccountBalanceLimitsRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->SetBalanceLimits(
            entity_id: $command->entity_id,
            minimum: $command->minimum,
            maximum: $command->maximum,
        );

        return [$aggregate, $events];
    }
}
