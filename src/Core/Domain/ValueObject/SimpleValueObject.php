<?php
namespace Core\Domain\ValueObject;

abstract class SimpleValueObject extends ValueObject
{

    readonly public mixed $value;

    /**
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
    /**
     * Specify data which should be serialized to JSON
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
     */
    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
    public function isInitial(): bool
    {
        return empty($this->value);
    }
}