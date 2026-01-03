<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\EventHandler\QueryProjection\Account;

use Banking\Infrastructure\Doctrine\Mapper\DoctrineOperationMapper;
use Banking\Infrastructure\Doctrine\Repository\Account\DoctrineOperationEntityRepository;
use Core\Infrastructure\Doctrine\EventHandler\AbstractPersistEventHandler;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineOperationChangeEventHandler extends AbstractPersistEventHandler
{
    public function __construct(
        DoctrineOperationEntityRepository $repo,
        DoctrineOperationMapper $mapper,
        EntityManagerInterface $em
    ) {
        parent::__construct($repo, $mapper, $em);
    }

    public function listenTo(): iterable
    {
        yield [];
    }
}
