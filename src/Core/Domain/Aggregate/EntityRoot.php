<?php

namespace Core\Domain\Aggregate;

abstract class EntityRoot extends Entity
{

    public function isRoot(): bool
    {
        return true;
    }

}