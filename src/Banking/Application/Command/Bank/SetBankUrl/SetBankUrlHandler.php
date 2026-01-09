<?php

namespace Banking\Application\Command\Bank\SetBankUrl;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Core\Application\Command\CommandHandler;

final class SetBankUrlHandler extends AbstractSetBankUrlHandler implements CommandHandler
{
    protected function check(
        BankAggregate $aggregate,
        SetBankUrlRequest $command,
    ): void {
        // TODO some checks
    }

    protected function save(
        BankAggregate $aggregate,
        SetBankUrlRequest $command,
    ): array {
        [$aggregate, $events] = $aggregate->getRoot()->Change(
            entity_id: $command->entity_id,
            url: $command->url,
        );

        return [$aggregate, $events];
    }
}
