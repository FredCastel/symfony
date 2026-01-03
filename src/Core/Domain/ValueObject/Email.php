<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;
use Core\Domain\Model\Constraint\UrlConstraint;

class Email extends SimpleValueObject
{
    protected function internalCheck(): void
    {
        Assert::that($this->value)
            ->notEmpty()
            ->notNull()
            ->string()
            ->email();
    }
}