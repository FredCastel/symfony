<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\RemoveAccountOperation;

use Banking\Application\Command\Account\_Tools\Getter\AccountAggregateGetterTrait;
use Banking\Application\Command\Account\_Tools\Getter\OperationGetterTrait;
use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\Repository\Account\AccountAggregateRepository;
use Banking\Domain\Repository\Account\OperationEntityRepository;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Domain\Aggregate\AggregateValidator;

abstract class AbstractRemoveAccountOperationHandler implements CommandHandler
{
    use AccountAggregateGetterTrait;
    use OperationGetterTrait;

    public function __construct(
        protected AccountAggregateRepository $accountAggregateRepository,
        protected OperationEntityRepository $operationEntityRepository,
    ) {
    }

    public function listenTo(): string
    {
        return RemoveAccountOperationRequest::class;
    }

    /**
     * @param RemoveAccountOperationRequest $command
     */
    public function execute(CommandRequest $command): CommandResponse
    {
        $aggregate = $this->requireAccountAggregate($command->id);
        // $entity = $this->requireOperationEntity($command->id);

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
        RemoveAccountOperationRequest $command,
    ): void;

    abstract protected function save(
        AccountAggregate $aggregate,
        RemoveAccountOperationRequest $command,
    ): array;
}
