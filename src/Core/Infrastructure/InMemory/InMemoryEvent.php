<?php

namespace Core\Infrastructure\InMemory;

use Core\Domain\Event\Event;

class InMemoryEvent {
public function __construct(
    public int $id,
    public string $aggregate,
    public int $aggregateId,
    public int $version,
    public Event $event,
)
{

}
}