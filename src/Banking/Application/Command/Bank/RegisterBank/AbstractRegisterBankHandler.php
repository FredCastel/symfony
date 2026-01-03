<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\RegisterBank;

use Banking\Application\Command\Bank\_Tools\Getter\BankAggregateGetterTrait;
use Banking\Application\Command\Bank\_Tools\Getter\BankGetterTrait;
use Banking\Domain\Repository\Bank\BankAggregateRepository;
use Banking\Domain\Repository\Bank\BankEntityRepository;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Domain\Aggregate\AggregateValidator;
use Core\Service\IdGenerator;

abstract class AbstractRegisterBankHandler implements CommandHandler
{
    use BankAggregateGetterTrait;
    use BankGetterTrait;

    public function __construct(
        protected IdGenerator $idGenerator,
        protected BankAggregateRepository $bankAggregateRepository,
        protected BankEntityRepository $bankEntityRepository,
    ) {
    }

    public function listenTo(): string
    {
        return RegisterBankRequest::class;
    }

    /**
     * @param RegisterBankRequest $command
     */
    public function execute(CommandRequest $command): CommandResponse
    {
        $this->check(
            $command,
        );

        [$aggregate, $events] = $this->save(
            $command,
        );

        $validator = new AggregateValidator();
        $validator->validate($aggregate);

        $this->bankAggregateRepository->save($aggregate, $events);

        return CommandResponse::withEvents($events);
    }

    abstract protected function check(
        RegisterBankRequest $command,
    ): void;

    abstract protected function save(
        RegisterBankRequest $command,
    ): array;
}
