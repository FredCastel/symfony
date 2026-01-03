<?php

namespace Core\Domain\Repository;

use Core\Domain\Repository\Dependency;

class Dependencies implements \Iterator
{
    private int $position = 0;

    public function __construct(public iterable $dependencies)
    {
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
    function current(): Dependency
    {
        return $this->dependencies[$this->position];
    }
    function key(): int|null
    {
        return $this->position;
    }
    function next(): void
    {
        ++$this->position;
    }
    function valid(): bool
    {
        return isset($this->dependencies[$this->position]);
    }

    static function filter(Dependencies $dependencies, string $class): iterable
    {
        $list = [];
        foreach ($dependencies->dependencies as $key => $value) {
            if (key_exists($class, class_implements($value))) {
                $list[$key] = $value;
            }
        }
        return $list;
    }
}