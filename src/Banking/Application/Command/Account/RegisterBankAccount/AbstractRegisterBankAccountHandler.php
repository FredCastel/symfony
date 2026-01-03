<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\RegisterBankAccount;

use Banking\Application\Command\Account\_Tools\Getter\AccountAggregateGetterTrait;
use Banking\Application\Command\Account\_Tools\Getter\AccountGetterTrait;
use Banking\Domain\Repository\Account\AccountAggregateRepository;
use Banking\Domain\Repository\Account\AccountEntityRepository;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Domain\Aggregate\AggregateValidator;
use Core\Service\IdGenerator;

abstract class AbstractRegisterBankAccountHandler implements CommandHandler
{
    use AccountAggregateGetterTrait;
    use AccountGetterTrait;

    public function __construct(
        protected IdGenerator $idGenerator,
        protected AccountAggregateRepository $accountAggregateRepository,
        protected AccountEntityRepository $accountEntityRepository,
    ) {
    }

    public function listenTo(): string
    {
        return RegisterBankAccountRequest::class;
    }

    /**
     * @param RegisterBankAccountRequest $command
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

        $this->accountAggregateRepository->save($aggregate, $events);

        return CommandResponse::withEvents($events);
    }

    abstract protected function check(
        RegisterBankAccountRequest $command,
    ): void;

    abstract protected function save(
        RegisterBankAccountRequest $command,
    ): array;
}
