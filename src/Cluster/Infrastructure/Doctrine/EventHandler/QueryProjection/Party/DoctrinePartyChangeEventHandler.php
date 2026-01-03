<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Infrastructure\Doctrine\EventHandler\QueryProjection\Party;

use Cluster\Domain\Event\Party\PartyDisabledEvent;
use Cluster\Domain\Event\Party\PartyEnabledEvent;
use Cluster\Domain\Event\Party\PartyRenamedEvent;
use Cluster\Infrastructure\Doctrine\Mapper\DoctrinePartyMapper;
use Cluster\Infrastructure\Doctrine\Repository\Party\DoctrinePartyEntityRepository;
use Core\Infrastructure\Doctrine\EventHandler\AbstractPersistEventHandler;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrinePartyChangeEventHandler extends AbstractPersistEventHandler
{
    public function __construct(
        DoctrinePartyEntityRepository $repo,
        DoctrinePartyMapper $mapper,
        EntityManagerInterface $em
    ) {
        parent::__construct($repo, $mapper, $em);
    }

    public function listenTo(): iterable
    {
        yield PartyEnabledEvent::class;

        yield PartyDisabledEvent::class;

        yield PartyRenamedEvent::class;
    }
}
