<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Repository\Account;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Repository\AggregateRepository;

interface AccountAggregateRepository extends AggregateRepository
{
    /**
     * @param AccountAggregate $aggregate
     */
    public function save(Aggregate $aggregate, array $events): void;

    /**
     * @return AccountAggregate
     */
    public function get(string $id): Aggregate;
}
