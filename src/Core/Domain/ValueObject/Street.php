<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Street extends SimpleValueObject
{
    protected function internalCheck(): void
    {
        Assert::that($this->value)
            ->notEmpty()
            ->notNull()
            ->string();
    }
}