<?php

namespace Tests\Banking\Infrastructure\InMemory;

use Core\Infrastructure\InMemory\InMemoryAggregateRepository;

class InMemoryBankAggregateRepository extends InMemoryAggregateRepository implements \Banking\Domain\Repository\Bank\BankAggregateRepository
{
    public function __construct()
    {
        parent::__construct(\Banking\Domain\Aggregate\Bank\BankAggregate::class);
    }
}