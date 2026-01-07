<?php

namespace Core\Infrastructure\InMemory;

use Core\Domain\Aggregate\Aggregate;
use Symfony\Component\Serializer\Serializer;

abstract class InMemoryAggregateRepository 
{
    protected Serializer $serializer;
    private IntIdGenerator $idGenerator;
    /**
     * @var InMemoryEvent[]
     */
    static private array $events = [];

    public function __construct(
        private readonly string $aggregateClass,
    ) {
        $this->idGenerator = new IntIdGenerator();
    }

    public function save(Aggregate $aggregate, array $events): void
    {
        //check version        
        $version = $this->getAggregateVersion($aggregate->getId()->value) + 1;

        if ($version != $aggregate->getVersion()->value)
            throw new \Exception("Aggregation " . get_class($aggregate) . " version is " . $aggregate->getVersion()->value . " need $version", 1);

        foreach ($events as $event) {
            $inMemoryEvent = new InMemoryEvent(
                id: $this->idGenerator->next(),
                aggregate: get_class($aggregate),
                aggregateId: $aggregate->getId()->value,
                version: $version,
                event: $event,
                );
            static::$events[] = $inMemoryEvent;
        }
    }

    public function get(string $id): Aggregate
    {
        $events = $this->getEventsByAggregate($id);
        $class = $this->aggregateClass;

        $instance = new $class(new \Core\Domain\ValueObject\Id($id));
        foreach ($events as $inMemoryEvent) {
            $instance = $instance->apply($inMemoryEvent->event);
        }
        return $instance;
    }

    /**
     * @return InMemoryEvent[]
     */
    protected function getEventsByAggregate(string $id) :array
    {
        return array_filter(static::$events, function (InMemoryEvent $event) use ($id) {
            return $event->aggregateId == $id;
        });
    }

    protected function getAggregateVersion(string $id): int
    {
        foreach (array_reverse(static::$events) as $event) {
            if ($event->aggregateId == $id) {
                return $event->version;
            }
        }
        return 0;
    }
}