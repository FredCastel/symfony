<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Repository\Bank;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Repository\AggregateRepository;

interface BankAggregateRepository extends AggregateRepository
{
    /**
     * @param BankAggregate $aggregate
     */
    public function save(Aggregate $aggregate, array $events): void;

    /**
     * @return BankAggregate
     */
    public function get(string $id): Aggregate;
}
