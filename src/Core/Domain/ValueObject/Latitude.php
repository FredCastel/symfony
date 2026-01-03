<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Latitude extends GeographicCoordinate
{
    protected function internalCheck(): void
    {
        parent::internalCheck();
        Assert::that($this->value)
            ->min(-90)
            ->max(+90);
    }
}