<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class ZipCode extends SimpleValueObject
{
    protected function internalCheck(): void
    {
        Assert::that($this->value)
            ->notEmpty()
            ->notNull()
            ->string()
            ->alnum()
            ->minLength(5)
            ->maxLength(10);
    }
}