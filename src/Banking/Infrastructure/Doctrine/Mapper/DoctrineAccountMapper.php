<?php

namespace Banking\Infrastructure\Doctrine\Mapper;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\Aggregate\Account\Entity\Account;
use Banking\Infrastructure\Doctrine\Entity\DoctrineAccount;
use Banking\Infrastructure\Doctrine\Repository\Bank\DoctrineBankEntityRepository;
use Cluster\Infrastructure\Doctrine\Repository\Party\DoctrinePartyEntityRepository;
use Core\Domain\Aggregate\Entity;
use Core\Infrastructure\Doctrine\DoctrineEntity;
use Core\Infrastructure\Doctrine\Mapper\EntityMapper;
use Symfony\Component\Uid\Uuid;

final class DoctrineAccountMapper extends EntityMapper
{
    /**
     * Summary of __construct.
     *
     * @param DoctrineBankEntityRepository        * @param DoctrinePartyEntityRepository         */
    public function __construct(
        private DoctrineBankEntityRepository $bankidRepository,
        private DoctrinePartyEntityRepository $partyidRepository,
    ) {
    }

    public function getAggregateClass(): string
    {
        return AccountAggregate::class;
    }

    public function getEntityClass(): string
    {
        return Account::class;
    }

    public function getDoctrineEntityClass(): string
    {
        return DoctrineAccount::class;
    }

    /**
     * convert Model to Doctrine Entity.
     *
     * @param DoctrineAccount $doctrineEntity
     * @param Account         $entity
     *
     * @return DoctrineAccount
     */
    public function fromModel(?DoctrineEntity $doctrineEntity, ?Entity $entity): ?DoctrineEntity
    {
        if (null == $entity) {
            return null;
        }

        $doctrineEntity
            ->setId(Uuid::fromString($entity->getId()->value))
                                    ->setName($entity->getName()->value)
                                                ->setState($entity->getState()->value)
                                                ->setCategory($entity->getCategory()->value)
                                                ->setCurrencycode($entity->getCurrency()->code)
                                                ->setBalance($entity->getBalance()->value)
                                                ->setInitialbalance($entity->getInitialBalance() ? ($entity->getinitialBalance()->value) : null)
                                                ->setMinimumbalance($entity->getMinimumBalance() ? ($entity->getminimumBalance()->value) : null)
                                                ->setMaximumbalance($entity->getMaximumBalance() ? ($entity->getmaximumBalance()->value) : null)
                                                ->setValidityperiodsince(new \DateTimeImmutable($entity->getValidityPeriod()->since))
                                                ->setValidityperioduntil(new \DateTimeImmutable($entity->getValidityPeriod()->until))
        ;

        // bankId relation
        if ($entity->getBankId()) {
            $bankEntity = $this->bankidRepository->find(id: Uuid::fromString($entity->getBankId()->value));
            $doctrineEntity->setBankid($bankEntity);
        } else {
            $doctrineEntity->setBankid(null);
        }

        // partyId relation
        if ($entity->getPartyId()) {
            $partyEntity = $this->partyidRepository->find(id: Uuid::fromString($entity->getPartyId()->value));
            $doctrineEntity->setPartyid($partyEntity);
        } else {
            $doctrineEntity->setPartyid(null);
        }

        return $doctrineEntity;
    }
}
