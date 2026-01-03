<?php

namespace Core\Infrastructure\Doctrine;

use Core\Service\IdGenerator;
use Symfony\Component\Uid\Uuid;

class DoctrineIdGenerator implements IdGenerator
{

    /**
     * @return string
     */
    public function next(): string
    {
        return Uuid::v1()->__toString();
    }
}