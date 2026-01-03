<?php

namespace Core\Domain\Repository;

use Core\Domain\Aggregate\Entity;

interface EntityRepository
{
    public function get(string $id): Entity;
}