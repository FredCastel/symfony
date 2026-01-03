<?php

namespace Core\Domain\Event;

abstract class AbstractEventAddressChanged extends AbstractEvent
{
    public function __construct(
        public string $id,
        public string $name,
        public string $street,
        public string $zipCode,
        public string $city,
        public string $country,
        public ?string $validSince = null,
        public ?string $validUntil = null,
    ) {
        parent::__construct($id);
    }
}