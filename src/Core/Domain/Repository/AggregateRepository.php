<?php

namespace Core\Domain\Repository;

use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Event\Event;


interface AggregateRepository
{
    /**
     * Summary of save
     * @param Aggregate $aggregate
     * @param Event[] $events
     * @return void
     */
    public function save(Aggregate $aggregate, array $events): void;


    public function get(string $id): Aggregate;
}