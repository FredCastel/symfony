<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Infrastructure\Doctrine\Repository\Account;

use Banking\Domain\Aggregate\Account\Entity\Account;
use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Banking\Domain\Repository\Account\AccountAggregateRepository;
use Banking\Domain\Repository\Account\AccountEntityRepository;
use Banking\Infrastructure\Doctrine\Entity\DoctrineAccount;
use Banking\Infrastructure\Doctrine\Mapper\DoctrineBankMapper;
use Cluster\Domain\Aggregate\Party\Entity\Party;
use Cluster\Infrastructure\Doctrine\Mapper\DoctrinePartyMapper;
use Core\Infrastructure\Doctrine\DoctrineEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineAccountEntityRepository extends DoctrineEntityRepository implements AccountEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        AccountAggregateRepository $aggregateRepository,
    ) {
        parent::__construct($registry, $aggregateRepository);
    }

    public function getEntityClass(): string
    {
        return Account::class;
    }

    public function getDoctrineEntityClass(): string
    {
        return DoctrineAccount::class;
    }

    public function usedBank(Bank $entity): bool
    {
        $mapper = new DoctrineBankMapper();

        $entityClass = $mapper->getDoctrineClass();
        $doctrineEntity = new $entityClass();
        $mapper->fromModel(doctrineEntity: $doctrineEntity, entity: $entity);

        $result = $this->findOneBy(['Bank' => $doctrineEntity]);

        return $result ? true : false;
    }

    public function usedParty(Party $entity): bool
    {
        $mapper = new DoctrinePartyMapper();

        $entityClass = $mapper->getDoctrineClass();
        $doctrineEntity = new $entityClass();
        $mapper->fromModel(doctrineEntity: $doctrineEntity, entity: $entity);

        $result = $this->findOneBy(['Party' => $doctrineEntity]);

        return $result ? true : false;
    }
}
