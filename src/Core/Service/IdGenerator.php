<?php declare(strict_types=1);

namespace Core\Service;

interface IdGenerator
{
    public function next(): string;
}