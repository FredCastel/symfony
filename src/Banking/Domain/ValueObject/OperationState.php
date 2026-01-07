<?php

namespace Banking\Domain\ValueObject;

use Core\Domain\ValueObject\State;

/**
 * @todo adjust this definition
 */
final class OperationState extends State
{
    public const TICKED = 'ticked';
    public const NONE = 'none';

    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function TICKED(): self
    {
        return new self(
            value: self::TICKED,
        );
    }

    public static function NONE(): self
    {
        return new self(
            value: self::NONE,
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
