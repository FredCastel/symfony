<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\_Tools\Getter;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Banking\Domain\Repository\Bank\BankAggregateRepository;
use Core\Application\Command\CommandNotFoundEntityException;
use Core\Application\Command\CommandRequiredEntityException;

trait BankAggregateGetterTrait
{
    protected BankAggregateRepository $bankAggregateRepository;

    public function findBankAggregate(?string $id): ?BankAggregate
    {
        if (null == $id || '' == $id) {
            return null;
        }

        $aggregate = $this->bankAggregateRepository->get($id);

        if (null == $aggregate) {
            throw new CommandNotFoundEntityException('Bank aggregate does not exists');
        }

        return $aggregate;
    }

    public function requireBankAggregate(?string $id): BankAggregate
    {
        if (null == $id || '' == $id) {
            throw new CommandRequiredEntityException('Bank is required');
        }

        return $this->FindBankAggregate($id);
    }
}
