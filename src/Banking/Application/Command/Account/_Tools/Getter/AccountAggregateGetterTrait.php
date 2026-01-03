<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\_Tools\Getter;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\Repository\Account\AccountAggregateRepository;
use Core\Application\Command\CommandNotFoundEntityException;
use Core\Application\Command\CommandRequiredEntityException;

trait AccountAggregateGetterTrait
{
    protected AccountAggregateRepository $accountAggregateRepository;

    public function findAccountAggregate(?string $id): ?AccountAggregate
    {
        if (null == $id || '' == $id) {
            return null;
        }

        $aggregate = $this->accountAggregateRepository->get($id);

        if (null == $aggregate) {
            throw new CommandNotFoundEntityException('Account aggregate does not exists');
        }

        return $aggregate;
    }

    public function requireAccountAggregate(?string $id): AccountAggregate
    {
        if (null == $id || '' == $id) {
            throw new CommandRequiredEntityException('Account is required');
        }

        return $this->FindAccountAggregate($id);
    }
}
