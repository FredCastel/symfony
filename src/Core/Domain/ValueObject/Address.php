<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Address extends ValueObject
{

    public function __construct(
        protected Name $name,
        protected ValidityPeriod $validityPeriod,
        protected ?AddressLocation $location,
        protected ?AddressCommunication $commmunication,
    ) {
    }

    public function isInitial(): bool
    {
        return $this->location->isInitial() && $this->commmunication->isInitial();
    }

    public function getName(): Name
    {
        return $this->name;
    }
    public function getValidityPeriod(): ValidityPeriod
    {
        return $this->validityPeriod;
    }
    public function getLocation(): ?AddressLocation
    {
        return $this->location;
    }
    public function getCommmunication(): ?AddressCommunication
    {
        return $this->commmunication;
    }

    protected function internalCheck(): void
    {
        $this->location?->internalCheck();
        $this->commmunication?->internalCheck();
    }

    public function __toString()
    {
        return (string) $this->name . " - "
            . $this->location->__toString();
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => json_encode($this->name),
            'location' => json_encode($this->location),
            'communication' => json_encode($this->commmunication),
        ];
    }
}