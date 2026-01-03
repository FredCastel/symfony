<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\Repository\Account;

use Banking\Domain\Aggregate\Account\Entity\Operation;
use Banking\Domain\Repository\Account\AccountAggregateRepository;
use Banking\Domain\Repository\Account\OperationEntityRepository;
use Banking\Infrastructure\Doctrine\Entity\DoctrineOperation;
use Core\Infrastructure\Doctrine\DoctrineEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineOperationEntityRepository extends DoctrineEntityRepository implements OperationEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        AccountAggregateRepository $aggregateRepository,
    ) {
        parent::__construct($registry, $aggregateRepository);
    }

    public function getEntityClass(): string
    {
        return Operation::class;
    }

    public function getDoctrineEntityClass(): string
    {
        return DoctrineOperation::class;
    }
}
