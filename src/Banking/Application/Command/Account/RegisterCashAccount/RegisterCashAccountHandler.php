<?php

namespace Banking\Application\Command\Account\RegisterCashAccount;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\ValueObject\AccountCategory;
use Banking\Domain\ValueObject\AccountState;
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
        [$aggregate, $events] = (new AccountAggregate(new Id($command->id)))->getRoot()->register(
            entity_id: $command->entity_id,
            name: $command->name,
            state: AccountState::DRAFT,
            category: AccountCategory::CASH,
            currency: $command->currency,
            bankId: null,
            partyId: $command->partyId,
        );

        return [$aggregate, $events];
    }
}
