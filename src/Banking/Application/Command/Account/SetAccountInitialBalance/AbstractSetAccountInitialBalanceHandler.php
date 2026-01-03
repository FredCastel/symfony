<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\SetAccountInitialBalance;

use Banking\Application\Command\Account\_Tools\Getter\AccountAggregateGetterTrait;
use Banking\Application\Command\Account\_Tools\Getter\AccountGetterTrait;
use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\Repository\Account\AccountAggregateRepository;
use Banking\Domain\Repository\Account\AccountEntityRepository;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Domain\Aggregate\AggregateValidator;

abstract class AbstractSetAccountInitialBalanceHandler implements CommandHandler
{
    use AccountAggregateGetterTrait;
    use AccountGetterTrait;

    public function __construct(
        protected AccountAggregateRepository $accountAggregateRepository,
        protected AccountEntityRepository $accountEntityRepository,
    ) {
    }

    public function listenTo(): string
    {
        return SetAccountInitialBalanceRequest::class;
    }

    /**
     * @param SetAccountInitialBalanceRequest $command
     */
    public function execute(CommandRequest $command): CommandResponse
    {
        $aggregate = $this->requireAccountAggregate($command->id);
        // $entity = $this->requireAccountEntity($command->id);

        $this->check(
            $aggregate,
            $command,
        );

        [$aggregate, $events] = $this->save(
            $aggregate,
            $command,
        );

        $validator = new AggregateValidator();
        $validator->validate($aggregate);

        $this->accountAggregateRepository->save($aggregate, $events);

        return CommandResponse::withEvents($events);
    }

    abstract protected function check(
        AccountAggregate $aggregate,
        SetAccountInitialBalanceRequest $command,
    ): void;

    abstract protected function save(
        AccountAggregate $aggregate,
        SetAccountInitialBalanceRequest $command,
    ): array;
}
