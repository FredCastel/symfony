<?php

namespace Core\Domain\Aggregate;

use Core\Domain\ValueObject\Id;

abstract class EntityChild extends Entity
{   

    public function __construct(
        protected Id $id,
        protected Aggregate $aggregate,
        protected Entity $parent,
    ) {
        parent::__construct($id, $aggregate);
    }

    public function isChild(): bool
    {
        return true;
    }
}