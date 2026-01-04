<?php

namespace Core\Infrastructure\Doctrine;

use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Repository\AggregateRepository;
use Core\Infrastructure\Doctrine\Entity\DoctrineEntityKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;

abstract class DoctrineEntityRepository extends ServiceEntityRepository
{
    protected Serializer $serializer;

    public function __construct(
        ManagerRegistry $registry,
        protected AggregateRepository $aggregateRepository,
    ) {
        parent::__construct($registry, static::getDoctrineEntityClass());
    }

    abstract public function getEntityClass(): string;
    abstract public function getDoctrineEntityClass(): string;


    public function get(string $id): Entity
    {
        //get aggregate from entity
        $aggregate = $this->getEntityAggregate($id);
        //seach this entity in array
        return $aggregate->getEntities()[$id];
    }

    protected function getEntityAggregate(string $id): Aggregate
    {
        $table = DoctrineEntityKey::class;
        $dql = "SELECT e.aggregateId FROM $table as e 
            WHERE e.id = :id";
        $aggregateId = $this->getEntityManager()->createQuery($dql)
            ->setParameter('id', $id)
            ->getSingleScalarResult();
        return $this->aggregateRepository->get($aggregateId);
    }
}