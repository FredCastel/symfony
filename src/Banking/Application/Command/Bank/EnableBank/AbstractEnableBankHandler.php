<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\EnableBank;

use Banking\Application\Command\Bank\_Tools\Getter\BankAggregateGetterTrait;
use Banking\Application\Command\Bank\_Tools\Getter\BankGetterTrait;
use Banking\Domain\Aggregate\Bank\BankAggregate;
use Banking\Domain\Repository\Bank\BankAggregateRepository;
use Banking\Domain\Repository\Bank\BankEntityRepository;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Domain\Aggregate\AggregateValidator;

abstract class AbstractEnableBankHandler implements CommandHandler
{
    use BankAggregateGetterTrait;
    use BankGetterTrait;

    public function __construct(
        protected BankAggregateRepository $bankAggregateRepository,
        protected BankEntityRepository $bankEntityRepository,
    ) {
    }

    public function listenTo(): string
    {
        return EnableBankRequest::class;
    }

    /**
     * @param EnableBankRequest $command
     */
    public function execute(CommandRequest $command): CommandResponse
    {
        $aggregate = $this->requireBankAggregate($command->id);
        // $entity = $this->requireBankEntity($command->id);

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

        $this->bankAggregateRepository->save($aggregate, $events);

        return CommandResponse::withEvents($events);
    }

    abstract protected function check(
        BankAggregate $aggregate,
        EnableBankRequest $command,
    ): void;

    abstract protected function save(
        BankAggregate $aggregate,
        EnableBankRequest $command,
    ): array;
}
