<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Infrastructure\Doctrine\Repository\Party;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Cluster\Domain\Repository\Party\PartyAggregateRepository;
use Core\Infrastructure\Doctrine\DoctrineAggregateRepository;

final class DoctrinePartyAggregateRepository extends DoctrineAggregateRepository implements PartyAggregateRepository
{
    public function getAggregateClass(): string
    {
        return PartyAggregate::class;
    }
}
