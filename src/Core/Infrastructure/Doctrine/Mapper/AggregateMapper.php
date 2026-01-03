<?php

namespace Core\Infrastructure\Doctrine\Mapper;

use Core\Domain\Aggregate\Aggregate;
use Core\Infrastructure\Doctrine\DoctrineEntity;

abstract class AggregateMapper
{
    public function __construct(
    ) {
    }
    abstract public function getModelClass(): string;
    abstract public function getDoctrineClass(): string;
    abstract public function toModel(?DoctrineEntity $doctrineEntity): Aggregate;
    abstract public function fromModel(?DoctrineEntity $doctrineEntity, ?Aggregate $aggregate): ?DoctrineEntity;
}