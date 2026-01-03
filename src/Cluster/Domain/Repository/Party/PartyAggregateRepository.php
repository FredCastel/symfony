<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Domain\Repository\Party;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Repository\AggregateRepository;

interface PartyAggregateRepository extends AggregateRepository
{
    /**
     * @param PartyAggregate $aggregate
     */
    public function save(Aggregate $aggregate, array $events): void;

    /**
     * @return PartyAggregate
     */
    public function get(string $id): Aggregate;
}
