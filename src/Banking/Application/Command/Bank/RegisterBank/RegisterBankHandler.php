<?php

namespace Banking\Application\Command\Bank\RegisterBank;

use Banking\Domain\Aggregate\Bank\BankAggregate;
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
            state: 'todo',// TODO mapping rule
            country: $command->country,
            url: $command->url,
            bic: $command->bic,
            image: null,
            validSince: null,
            validUntil: null,
        );

        return [$aggregate, $events];
    }
}
