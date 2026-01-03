<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Longitude extends GeographicCoordinate
{
    protected function internalCheck(): void
    {
        parent::internalCheck();
        Assert::that($this->value)
            ->min(-180)
            ->max(+180);
    }
}