<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class GeographicCoordinates extends ValueObject
{
    public function __construct(
        protected Longitude $longitude,
        protected Latitude $latitude,
    ) {
    }

    public function isInitial(): bool
    {
        return $this->longitude->isInitial() && $this->latitude->isInitial();
    }
    public function getLongitude(): Longitude
    {
        return $this->longitude;
    }
    public function getLatitude(): Latitude
    {
        return $this->latitude;
    }

    protected function internalCheck(): void
    {
        $this->longitude->internalCheck();
        $this->latitude->internalCheck();
    }

    public function __toString()
    {
        return (string) $this->longitude->__toString() . " - " . $this->latitude->__toString();
    }

    public function jsonSerialize(): mixed
    {
        return [
            'longitude' => json_encode($this->longitude),
            'latitude' => json_encode($this->latitude),
        ];
    }
}