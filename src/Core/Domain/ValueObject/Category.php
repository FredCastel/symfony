<?php

namespace Core\Domain\ValueObject;

abstract class Category extends ConstantValueObject
{
    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }
}