<?php
namespace Core\Application\Command;

use Core\Application\Message\MessageInterface;
use Core\Domain\Event\Event;

class CommandResponse
{
    /**
     * Summary of __construct
     * @param Event[] $events
     * @param MessageInterface[] $messages
     */
    private function __construct(
        private iterable $events = [],
        private iterable $messages = []
    ) {
    }

    /**
     * 
     * @return Event[]
     */
    public function events(): iterable
    {
        return $this->events;
    }

    public function hasEvents(): bool
    {
        return $this->events !== null;
    }

    /**
     * Summary of withEvents
     * @param Event[] $events
     * @return \Core\Application\Command\CommandResponse
     */
    static public function withEvents(iterable $events): CommandResponse
    {
        return new self($events);
    }

    /**
     * 
     * @return MessageInterface[]
     */
    public function messages(): iterable
    {
        return $this->messages;
    }
    public function hasMessages(): bool
    {
        return $this->messages !== null;
    }

    /**
     * Summary of withMessages
     * @param \Core\Application\Message\MessageInterface[] $messages
     * @return \Core\Application\Command\CommandResponse
     */
    static public function withMessages(iterable $messages): CommandResponse
    {
        return new self(events: [], messages: $messages);
    }
}