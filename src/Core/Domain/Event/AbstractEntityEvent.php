<?php

namespace Core\Domain\Event;

class AbstractEntityEvent implements EntityEvent
{
    public function __construct(
        public string $id,
        public string $entity_id,
    ) {
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function getEntityId(): string
    {
        return $this->entity_id;
    }
}