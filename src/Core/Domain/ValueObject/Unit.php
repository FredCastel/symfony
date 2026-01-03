<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Unit extends SimpleValueObject
{
    public static function U(): Unit
    {
        return new Unit(
            value: "U",
        );
    }
    const LIST_CODE = [
        'U',
        'PCE',
        'T',
        'KG',
        'G',
        'M',
        'MM',
        'L',
        'ML',
        'J',
        'H',
        'M2'
    ];
    const LIST_DECIMALS = [
        'U' => 0,
        'PCE' => 0,
        'J' => 2,
        'H' => 2
    ];

    public function getDecimals(): int
    {
        return self::LIST_DECIMALS[$this->value] ?? 3;
    }

    protected function internalCheck(): void
    {
        Assert::that($this->value)
            ->notNull()
            ->notEmpty()
            ->inArray(self::LIST_CODE);
    }
}