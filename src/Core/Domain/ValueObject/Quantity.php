<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Quantity extends ValueObject
{
    readonly public float $value;
    protected Unit $unit;
    protected int $decimals;

    public function __construct(float $value, Unit $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
        $this->decimals = $this->unit->getDecimals();
    }

    public function getRawValue(): float
    {
        return $this->value * pow(10, $this->decimals);
    }
    public function getUnit(): Unit
    {
        return $this->unit;
    }

    protected function internalCheck(): void
    {
        $this->unit->check();
        Assert::that($this->getRawValue())
            ->notNull()
            ->float()
            ->between(-1e9, 1e9); //999 999 999.99
    }

    public function jsonSerialize(): mixed
    {
        return number_format($this->value, $this->unit->getDecimals());
    }

    public function isInitial(): bool
    {
        return empty($this->value);
    }
}