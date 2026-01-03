<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Percentage extends ValueObject
{
    readonly public float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function getRawValue(): float
    {
        return $this->value * pow(10, 2);
    }

    protected function internalCheck(): void
    {
        Assert::that($this->getRawValue())
            ->notNull()
            ->float()
            ->between(lowerLimit: -1000, upperLimit: 100); //999 999 999.99
    }

    public function jsonSerialize(): mixed
    {
        return number_format($this->value, 2);
    }

    public function isInitial(): bool
    {
        return empty($this->value);
    }
}