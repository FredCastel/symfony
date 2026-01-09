<?php

namespace Banking\Infrastructure\Doctrine\Mapper;

use Banking\Domain\Aggregate\Bank\BankAggregate;
use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Banking\Infrastructure\Doctrine\Entity\DoctrineBank;
use Core\Domain\Aggregate\Entity;
use Core\Infrastructure\Doctrine\DoctrineEntity;
use Core\Infrastructure\Doctrine\Mapper\EntityMapper;
use Symfony\Component\Uid\Uuid;

final class DoctrineBankMapper extends EntityMapper
{
    /**
     * Summary of __construct.
     */
    public function __construct(
    ) {
    }

    public function getAggregateClass(): string
    {
        return BankAggregate::class;
    }

    public function getEntityClass(): string
    {
        return Bank::class;
    }

    public function getDoctrineEntityClass(): string
    {
        return DoctrineBank::class;
    }

    /**
     * convert Model to Doctrine Entity.
     *
     * @param DoctrineBank $doctrineEntity
     * @param Bank         $entity
     *
     * @return DoctrineBank
     */
    public function fromModel(?DoctrineEntity $doctrineEntity, ?Entity $entity): ?DoctrineEntity
    {
        if (null == $entity) {
            return null;
        }
        $doctrineEntity
            ->setId(Uuid::fromString($entity->getId()->value))
                                    ->setName($entity->getName()->value)
                                                ->setCountrycode($entity->getCountry()->code)
                                                ->setState($entity->getState()->value)
                                                ->setValidityperiodsince(new \DateTimeImmutable($entity->getValidityPeriod()->since))
                                                ->setValidityperioduntil(new \DateTimeImmutable($entity->getValidityPeriod()->until))
                                                ->setUrl($entity->getUrl() ? ($entity->geturl()->value) : null)
                                                ->setBic($entity->getBic() ? ($entity->getbic()->value) : null)
                                                ->setImage($entity->getImage() ? ($entity->getimage()->value) : null)
        ;

        return $doctrineEntity;
    }
}
