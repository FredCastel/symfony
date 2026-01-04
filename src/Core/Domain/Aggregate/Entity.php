<?php

namespace Core\Domain\Aggregate;

use Core\Domain\Event\AbstractEntityEvent;
use Core\Domain\Event\AbstractEvent;
use Core\Domain\ValueObject\Id;

abstract class Entity
{    
    public function __construct(
        protected Id $id,
        protected Aggregate $aggregate,
    ) {
    }

    public function apply(AbstractEvent $event): Entity{
        $method = 'apply' . substr(strrchr(get_class($event), '\\'), 1);

        if (!method_exists($this, $method)) {
            throw new \RuntimeException("Missing $method method for " . get_class($event) . " on " . get_class($this), 1  );
        }

        //call Entity's apply method
        return $this->$method($event);
    }

    public function getAggregate(): Aggregate
    {
        return $this->aggregate;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function isRoot(): bool
    {
        return false;
    }

    public function isChild(): bool
    {
        return false;
    }

    /**
    * check concistency of the entity
    * @throws EntityValidationException
    */
    abstract public function validate(): void;

    /**
     * get sub entities of this entity
     * @return Entity[]
     */
    abstract public function getChildEntities(): array;
}