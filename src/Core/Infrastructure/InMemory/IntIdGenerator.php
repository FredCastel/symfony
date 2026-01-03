<?php

namespace Core\Infrastructure\InMemory;


use Core\Service\IdGenerator;

class IntIdGenerator implements IdGenerator
{

    private static int $genId = 0;

    /**
     * @return string
     */
    public function next(): string
    {
        self::$genId++;
        return (string) self::$genId;
    }
}