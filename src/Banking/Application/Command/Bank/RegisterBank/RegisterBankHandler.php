<?php

namespace Banking\Application\Command\Bank\RegisterBank;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Banking\Domain\ValueObject\BankState;
use Core\Application\Command\CommandHandler;
use Core\Domain\ValueObject\Id;

final class RegisterBankHandler extends AbstractRegisterBankHandler implements CommandHandler
{
    protected function check(
        RegisterBankRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        RegisterBankRequest $command,
    ): array {
        [$aggregate, $events] = (new BankAggregate(new Id($command->id)))->getRoot()->register(
            entity_id: $command->entity_id,
            name: $command->name,
            state: BankState::ENABLED,
            country: $command->country,
            url: $command->url,
            bic: $command->bic,
        );

        return [$aggregate, $events];
    }
}
