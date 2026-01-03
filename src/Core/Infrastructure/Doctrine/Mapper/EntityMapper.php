<?php

namespace Core\Infrastructure\Doctrine\Mapper;

use Core\Domain\Aggregate\Entity;
use Core\Domain\Aggregate\Aggregate;
use Core\Infrastructure\Doctrine\DoctrineEntity;

abstract class EntityMapper
{
    public function __construct(
        protected AggregateMapper $aggregateMapper
    ) {
    }
    abstract public function getAggregateClass(): string;
    abstract public function getEntityClass(): string;
    abstract public function getDoctrineEntityClass(): string;
    //abstract public function toModel(?DoctrineEntity $doctrineEntity): Entity;
    abstract public function fromModel(?DoctrineEntity $doctrineEntity, ?Entity $entity): ?DoctrineEntity;
}