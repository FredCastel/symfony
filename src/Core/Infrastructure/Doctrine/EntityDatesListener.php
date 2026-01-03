<?php

namespace Core\Infrastructure\Doctrine;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Set Created and Updated Dates on entity changes
 */
class EntityDatesListener
{
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        if (method_exists($eventArgs->getObject(), 'setCreatedAt'))
            $eventArgs->getObject()->setCreatedAt(new \DateTimeImmutable());
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        if (method_exists($eventArgs->getObject(), 'setChangedAt'))
            $eventArgs->getObject()->setChangedAt(new \DateTimeImmutable());
    }
}