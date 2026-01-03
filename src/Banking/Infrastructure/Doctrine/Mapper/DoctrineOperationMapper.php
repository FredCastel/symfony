<?php

namespace Banking\Infrastructure\Doctrine\Mapper;

use Banking\Domain\Aggregate\Account\AccountAggregate;
use Banking\Domain\Aggregate\Account\Entity\Operation;
use Banking\Infrastructure\Doctrine\Entity\DoctrineOperation;
use Core\Domain\Aggregate\Entity;
use Core\Infrastructure\Doctrine\DoctrineEntity;
use Core\Infrastructure\Doctrine\Mapper\EntityMapper;
use Symfony\Component\Uid\Uuid;

final class DoctrineOperationMapper extends EntityMapper
{
    /**
     * Summary of __construct.
     */
    public function __construct(
    ) {
    }

    public function getAggregateClass(): string
    {
        return AccountAggregate::class;
    }

    public function getEntityClass(): string
    {
        return Operation::class;
    }

    public function getDoctrineEntityClass(): string
    {
        return DoctrineOperation::class;
    }

    /**
     * convert Model to Doctrine Entity.
     *
     * @param DoctrineOperation $doctrineEntity
     * @param Operation         $entity
     *
     * @return DoctrineOperation
     */
    public function fromModel(?DoctrineEntity $doctrineEntity, ?Entity $entity): ?DoctrineEntity
    {
        if (null == $entity) {
            return null;
        }

        $doctrineEntity
            ->setId(Uuid::fromString($entity->getId()->value))
                                    ->setLabel($entity->getLabel()->value)
                                                ->setState($entity->getState()->value)
                                                ->setCategory($entity->getCategory()->value)
                                                ->setAmount($entity->getAmount()->value)
                                                ->setValuedate(new \DateTimeImmutable($entity->getValueDate()->value))
                                                ->setOperationdate(new \DateTimeImmutable($entity->getOperationDate()->value))
        ;

        return $doctrineEntity;
    }
}
