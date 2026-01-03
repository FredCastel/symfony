<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Id extends SimpleValueObject
{
    protected function internalCheck(): void
    {
        Assert::that($this->value)
            ->notNull()
            ->notEmpty();
    }
}