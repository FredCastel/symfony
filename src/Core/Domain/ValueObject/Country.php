<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Country extends ValueObject
{
    const LIST_ALPHA2 = ['BE', 'ES', 'FR', 'DE'];
    
    /**
     */
    public function __construct(
        readonly public mixed $code
    )
    {
    }

    public function __toString()
    {
        return (string) $this->code;
    }

    /**
     * Specify data which should be serialized to JSON
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
     */
    public function jsonSerialize(): mixed
    {
        return $this->code;
    }
    public function isInitial(): bool
    {
        return empty($this->code);
    }

    protected function internalCheck(): void
    {
        Assert::that($this->code)
            ->notNull()
            ->notEmpty()
            ->inArray(self::LIST_ALPHA2);
    }
}