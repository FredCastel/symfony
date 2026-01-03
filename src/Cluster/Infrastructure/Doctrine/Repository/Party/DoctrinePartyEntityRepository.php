<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Infrastructure\Doctrine\Repository\Party;

use Cluster\Domain\Aggregate\Party\Entity\Party;
use Cluster\Domain\Repository\Party\PartyAggregateRepository;
use Cluster\Domain\Repository\Party\PartyEntityRepository;
use Cluster\Infrastructure\Doctrine\Entity\DoctrineParty;
use Core\Infrastructure\Doctrine\DoctrineEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrinePartyEntityRepository extends DoctrineEntityRepository implements PartyEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        PartyAggregateRepository $aggregateRepository,
    ) {
        parent::__construct($registry, $aggregateRepository);
    }

    public function getEntityClass(): string
    {
        return Party::class;
    }

    public function getDoctrineEntityClass(): string
    {
        return DoctrineParty::class;
    }
}
