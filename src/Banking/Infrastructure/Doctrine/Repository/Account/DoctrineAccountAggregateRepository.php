<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\Repository\Account;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\Repository\Account\AccountAggregateRepository;
use Core\Infrastructure\Doctrine\DoctrineAggregateRepository;

final class DoctrineAccountAggregateRepository extends DoctrineAggregateRepository implements AccountAggregateRepository
{
    public function getAggregateClass(): string
    {
        return AccountAggregate::class;
    }
}
