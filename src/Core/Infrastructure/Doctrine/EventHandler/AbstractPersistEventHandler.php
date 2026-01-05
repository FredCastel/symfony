<?php

namespace Core\Infrastructure\Doctrine\EventHandler;

use Core\Domain\Event\AbstractEvent;
use Core\Domain\Repository\AggregateRepository;
use Core\Domain\Repository\EntityRepository;
use Core\Domain\ValueObject\Id;
use Core\Infrastructure\Doctrine\Mapper\EntityMapper;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractPersistEventHandler extends AbstractEventHandler
{
    public function __construct(
        protected AggregateRepository $aggregateRepository,
        protected EntityRepository $repo,
        protected EntityMapper $mapper,
        protected EntityManagerInterface $em,
    ) {
        parent::__construct($em);
    }

    public function handle(AbstractEvent $event): void
    {
        //get entity
        $aggregate = $this->aggregateRepository->get($event->getId());
        $entity = $aggregate->getEntities()[$event->getId()]; //$this->repo->get($event->getEntityId());
        //convert to entity
        $entityClass = $this->mapper->getDoctrineEntityClass();
        $doctrineEntity = $this->mapper->fromModel(new $entityClass(), $entity);
        //insert
        $this->em->persist($doctrineEntity);
        $this->em->flush();
    }
}