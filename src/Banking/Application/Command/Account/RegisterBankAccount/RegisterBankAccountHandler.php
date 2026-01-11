<?php

namespace Banking\Application\Command\Account\RegisterBankAccount;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\ValueObject\AccountState;
use Core\Application\Command\CommandHandler;
use Core\Domain\ValueObject\Id;

final class RegisterBankAccountHandler extends AbstractRegisterBankAccountHandler implements CommandHandler
{
    protected function check(
        RegisterBankAccountRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        RegisterBankAccountRequest $command,
    ): array {
        [$aggregate, $events] = (new AccountAggregate(new Id($command->id)))->getRoot()->register(
            entity_id: $command->entity_id,
            name: $command->name,
            state: AccountState::DRAFT,
            category: $command->category,
            currency: $command->currency,
            bankId: $command->bankId,
            partyId: $command->partyId,
        );

        return [$aggregate, $events];
    }
}
