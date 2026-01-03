<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class AddressLocation extends ValueObject
{
    public function __construct(
        protected Street $street,
        protected ZipCode $zipCode,
        protected City $city,
        protected Country $country,
        protected ?GeographicCoordinates $coordinates,
    ) {
    }

    public function isInitial(): bool
    {
        return
            empty($this->street->value) &&
            empty($this->city->value) &&
            empty($this->zipCode->value) &&
            empty($this->country->value);
    }
    public function getStreet(): Street
    {
        return $this->street;
    }
    public function getZipCode(): ZipCode
    {
        return $this->zipCode;
    }
    public function getCity(): City
    {
        return $this->city;
    }
    public function getCountry(): Country
    {
        return $this->country;
    }
    public function getCoordinated(): GeographicCoordinates
    {
        return $this->coordinates;
    }

    protected function internalCheck(): void
    {

    }

    public function __toString()
    {
        return (string) 
            $this->street . " - " .
            $this->zipCode . $this->city;
    }

    public function jsonSerialize(): mixed
    {
        $array = [];
        if ($this->street)
            $array['street'] = json_encode($this->street);
        if ($this->zipCode)
            $array['zipCode'] = json_encode($this->zipCode);
        if ($this->city)
            $array['city'] = json_encode($this->city);
        if ($this->country)
            $array['country'] = json_encode($this->country);
        return $array;
    }
}