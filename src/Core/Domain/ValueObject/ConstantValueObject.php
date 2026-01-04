<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

abstract class ConstantValueObject extends SimpleValueObject
{
    public function __construct($value)
    {
        parent::__construct($value);

        // $values = [];
        // foreach (static::getAllowed() as $a) {
        //     $values[] = $a->value;
        // }
        // if (!in_array($value, $values)) {
        //     throw new \Exception("Value $value not allowed", 1);
        // } a revoir car boucle infinie 
    }

    protected function internalCheck(): void
    {
        Assert::that($this->value)
            ->notNull()
            ->notEmpty()
            ->inArray(static::getAllowed());
    }

    /**
     * Summary of getAllowed
     * @return ConstantValueObject[]
     */
    static abstract function getAllowed(): array;
}