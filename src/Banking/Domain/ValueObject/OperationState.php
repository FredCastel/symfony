<?php

namespace Banking\Domain\ValueObject;

use Core\Domain\ValueObject\State;

/**
 * @todo adjust this definition
 */
final class OperationState extends State
{
    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function TICKED(): self
    {
        return new self(
            value: 'ticked',
        );
    }

    public static function NONE(): self
    {
        return new self(
            value: 'none',
        );
    }

    /**
     * Summary of getAllowed.
     *
     * @return OperationState[]
     */
    public static function getAllowed(): array
    {
        return [
            self::TICKED(),
            self::NONE(),
        ];
    }
}
