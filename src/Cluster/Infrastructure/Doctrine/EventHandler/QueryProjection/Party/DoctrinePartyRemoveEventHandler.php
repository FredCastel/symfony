<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Infrastructure\Doctrine\EventHandler\QueryProjection\Party;

use Cluster\Domain\Event\Party\PartyRemovedEvent;
use Cluster\Infrastructure\Doctrine\Mapper\DoctrinePartyMapper;
use Cluster\Infrastructure\Doctrine\Repository\Party\DoctrinePartyEntityRepository;
use Core\Infrastructure\Doctrine\EventHandler\AbstractPersistEventHandler;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrinePartyRemoveEventHandler extends AbstractPersistEventHandler
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
        yield PartyRemovedEvent::class;
    }
}
