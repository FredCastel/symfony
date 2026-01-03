<?php

declare(strict_types=1);

namespace Core\Domain\Repository;

/**
 * @template T of object
 *
 * @extends \IteratorAggregate<T>
 */
interface PaginatorInterface extends \IteratorAggregate, \Countable
{
    public function getCurrentPage(): int;

    public function getItemsPerPage(): int;

    public function getLastPage(): int;

    public function getTotalItems(): int;
}