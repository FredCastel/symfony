<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Amount extends ValueObject
{
    readonly public float $value;
    protected Currency $currency;
    protected int $decimals;

    public function __construct(float $value, Currency $currency)
    {
        $this->value = $value;
        $this->currency = $currency;
        $this->decimals = $this->currency->getDecimals();
    }

    public function getRawValue(): float
    {
        return $this->value * pow(10, $this->decimals);
    }
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    protected function internalCheck(): void
    {
        $this->currency->check();
        Assert::that($this->getRawValue())
            ->notNull()
            ->float()
            ->between(-1e9, 1e9); //999 999 999.99
    }

    public function jsonSerialize(): mixed
    {
        return number_format($this->value, $this->currency->getDecimals());
    }

    public function isInitial(): bool
    {
        return empty($this->value);
    }
}