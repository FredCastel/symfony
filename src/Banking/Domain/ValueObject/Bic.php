<?php

namespace Banking\Domain\ValueObject;

use CORE\Domain\ValueObject\SimpleValueObject;
use Core\Service\Assert\Assert;

/**
 * @todo adjust this definition
 */
final class Bic extends SimpleValueObject
{
    private function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    protected function internalCheck(): void
    {
        // TODO
        /*Assert::that($this->value)
            ->notNull()
            ->notEmpty()
            ->string()
            ->alnum()
            ->minLength(8)
            ->maxLength(11)
            ->regex('/^([a-zA-Z]{4})([a-zA-Z]{2})(([2-9a-zA-Z]{1})([0-9a-np-zA-NP-Z]{1}))((([0-9a-wy-zA-WY-Z]{1})([0-9a-zA-Z]{2}))|([xX]{3})|)/');
            */
    }
}
