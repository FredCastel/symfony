<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Currency extends ValueObject
{
    const LIST_CODE = ['EUR', 'JPY', 'USD'];
    const LIST_DECIMALS = ['EUR' => 2, 'JPY' => 0, 'USD' => 2];


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

    public function getDecimals(): int
    {
        return self::LIST_DECIMALS[$this->code] ?? 2;
    }

    protected function internalCheck(): void
    {
        Assert::that($this->code)
            ->notNull()
            ->notEmpty()
            ->inArray(self::LIST_CODE);
    }
}