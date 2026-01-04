<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Infrastructure\Doctrine\EventHandler\QueryProjection\Party;

use Cluster\Domain\Event\Party\PartyRegisteredEvent;
use Cluster\Infrastructure\Doctrine\Mapper\DoctrinePartyMapper;
use Cluster\Infrastructure\Doctrine\Repository\Party\DoctrinePartyAggregateRepository;
use Cluster\Infrastructure\Doctrine\Repository\Party\DoctrinePartyEntityRepository;
use Core\Infrastructure\Doctrine\EventHandler\AbstractPersistEventHandler;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrinePartyPersistEventHandler extends AbstractPersistEventHandler
{
    public function __construct(
        DoctrinePartyAggregateRepository $aggregateRepository,
        DoctrinePartyEntityRepository $repo,
        DoctrinePartyMapper $mapper,
        EntityManagerInterface $em
    ) {
        parent::__construct($aggregateRepository, $repo, $mapper, $em);
    }

    public function listenTo(): iterable
    {
        yield PartyRegisteredEvent::class;
    }
}
