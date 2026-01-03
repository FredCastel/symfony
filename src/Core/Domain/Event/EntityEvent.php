<?php

namespace Core\Domain\Event;

interface EntityEvent extends Event
{
    public function getEntityId(): string;
}