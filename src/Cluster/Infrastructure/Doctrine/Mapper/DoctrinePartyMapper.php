<?php

namespace Cluster\Infrastructure\Doctrine\Mapper;

use Cluster\Domain\Aggregate\Party\Entity\Party;
use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Cluster\Infrastructure\Doctrine\Entity\DoctrineParty;
use Core\Domain\Aggregate\Entity;
use Core\Infrastructure\Doctrine\DoctrineEntity;
use Core\Infrastructure\Doctrine\Mapper\EntityMapper;
use Symfony\Component\Uid\Uuid;

final class DoctrinePartyMapper extends EntityMapper
{
    /**
     * Summary of __construct.
     */
    public function __construct(
    ) {
    }

    public function getAggregateClass(): string
    {
        return PartyAggregate::class;
    }

    public function getEntityClass(): string
    {
        return Party::class;
    }

    public function getDoctrineEntityClass(): string
    {
        return DoctrineParty::class;
    }

    /**
     * convert Model to Doctrine Entity.
     *
     * @param DoctrineParty $doctrineEntity
     * @param Party         $entity
     *
     * @return DoctrineParty
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
                                                ->setValidityperiodsince(new \DateTimeImmutable($entity->getValidityPeriod()->since))
                                                ->setValidityperioduntil(new \DateTimeImmutable($entity->getValidityPeriod()->until))
                                                ->setUrl($entity->getUrl() ? ($entity->geturl()->value) : null)
                                                ->setImage($entity->getImage() ? ($entity->getimage()->value) : null)
        ;

        return $doctrineEntity;
    }
}
