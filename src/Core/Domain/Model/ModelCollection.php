<?php

namespace Core\Domain\Model;

use Core\Domain\Repository\PaginatorInterface;

abstract class ModelCollection extends \ArrayObject
{
    private ?PaginatorInterface $paginator;

    public function __construct(array $models = [])
    {
        if (count($models))
            $this->append($models);
    }

    public function getPaginator(): ?PaginatorInterface
    {
        return $this->paginator;
    }
    public function setPaginator(?PaginatorInterface $paginator): self
    {
        $this->paginator = $paginator;
        return $this;
    }
}