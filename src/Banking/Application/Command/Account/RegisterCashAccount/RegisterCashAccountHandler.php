<?php

namespace Banking\Application\Command\Account\RegisterCashAccount;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Application\Command\CommandHandler;
use Core\Domain\ValueObject\Id;

final class RegisterCashAccountHandler extends AbstractRegisterCashAccountHandler implements CommandHandler
{
    protected function check(
        RegisterCashAccountRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        RegisterCashAccountRequest $command,
    ): array {
        [$aggregate, $events] = (new AccountAggregate(new Id($command->id)))->getRoot()->Register(
            entity_id: $command->entity_id,
            name: $command->name,
            state: 'todo',// TODO mapping rule
            category: 'todo',// TODO mapping rule
            currency: $command->currency,
            validSince: null,
            validUntil: null,
            bankId: null,
            partyId: $command->partyId,
        );

        return [$aggregate, $events];
    }
}
