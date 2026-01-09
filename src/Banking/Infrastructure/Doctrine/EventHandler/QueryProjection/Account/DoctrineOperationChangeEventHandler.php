<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\EventHandler\QueryProjection\Account;

use Banking\Infrastructure\Doctrine\Mapper\DoctrineOperationMapper;
use Banking\Infrastructure\Doctrine\Repository\Account\DoctrineAccountAggregateRepository;
use Banking\Infrastructure\Doctrine\Repository\Account\DoctrineOperationEntityRepository;
use Core\Infrastructure\Doctrine\EventHandler\AbstractUpdateEventHandler;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineOperationChangeEventHandler extends AbstractUpdateEventHandler
{
    public function __construct(
        DoctrineAccountAggregateRepository $aggregateRepository,
        DoctrineOperationEntityRepository $repo,
        DoctrineOperationMapper $mapper,
        EntityManagerInterface $em
    ) {
        parent::__construct($aggregateRepository, $repo, $mapper, $em);
    }

    public function listenTo(): iterable
    {
        return [];
    }
}
