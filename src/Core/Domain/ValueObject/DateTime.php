<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class DateTime extends ValueObject
{
    readonly public ?\DateTimeImmutable $value;

    /**
     */
    public function __construct(?string $value)
    {
        if ($value == null) {
            $this->value = null;
        } else {
            $this->value = new \DateTimeImmutable($value);
        }
    }

    public function getValue()
    {
        return $this->value->format(\DateTime::W3C);
    }

    public function __toString()
    {
        return (string) $this->getValue();
    }
    /**
     * Specify data which should be serialized to JSON
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
     */
    public function jsonSerialize(): mixed
    {
        return $this->getValue();
    }

    protected function internalCheck(): void
    {
    }
    public function isInitial(): bool
    {
        return empty($this->value);
    }
}