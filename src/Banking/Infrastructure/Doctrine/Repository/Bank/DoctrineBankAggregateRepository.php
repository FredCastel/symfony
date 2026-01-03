<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\Repository\Bank;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Banking\Domain\Repository\Bank\BankAggregateRepository;
use Core\Infrastructure\Doctrine\DoctrineAggregateRepository;

final class DoctrineBankAggregateRepository extends DoctrineAggregateRepository implements BankAggregateRepository
{
    public function getAggregateClass(): string
    {
        return BankAggregate::class;
    }
}
