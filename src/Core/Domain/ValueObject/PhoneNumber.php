<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class PhoneNumber extends SimpleValueObject
{
    protected function internalCheck(): void
    {
        Assert::that($this->value)
            ->notEmpty()
            ->notNull()
            ->numeric();
    }
}