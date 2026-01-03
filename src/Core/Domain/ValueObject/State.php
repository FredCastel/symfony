<?php

namespace Core\Domain\ValueObject;

abstract class State extends ConstantValueObject
{
    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }
}