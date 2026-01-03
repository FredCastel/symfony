<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\Repository\Bank;

use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Banking\Domain\Repository\Bank\BankAggregateRepository;
use Banking\Domain\Repository\Bank\BankEntityRepository;
use Banking\Infrastructure\Doctrine\Entity\DoctrineBank;
use Core\Infrastructure\Doctrine\DoctrineEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineBankEntityRepository extends DoctrineEntityRepository implements BankEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        BankAggregateRepository $aggregateRepository,
    ) {
        parent::__construct($registry, $aggregateRepository);
    }

    public function getEntityClass(): string
    {
        return Bank::class;
    }

    public function getDoctrineEntityClass(): string
    {
        return DoctrineBank::class;
    }
}
