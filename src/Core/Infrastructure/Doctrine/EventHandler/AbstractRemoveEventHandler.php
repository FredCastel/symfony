<?php

namespace Core\Infrastructure\Doctrine\EventHandler;

use Core\Domain\Event\AbstractEvent;
use Core\Domain\Repository\EntityRepository;
use Core\Infrastructure\Doctrine\Mapper\EntityMapper;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractRemoveEventHandler extends AbstractEventHandler
{
    public function __construct(
        protected EntityRepository $repo,
        protected EntityMapper $mapper,
        protected EntityManagerInterface $em,
    ) {
        parent::__construct($em);
    }

    public function handle(AbstractEvent $event): void
    {
        //get entity
        $entity = $this->repo->get($event->getEntityId());
        //get entity
        $entityClass = $this->mapper->getDoctrineEntityClass();
        $doctrineEntity = $this->em->find($entityClass, $entity->getId()->value);
        //remove
        $this->em->remove($doctrineEntity);
        $this->em->flush();
    }
}