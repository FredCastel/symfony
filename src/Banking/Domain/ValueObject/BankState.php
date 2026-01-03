<?php

namespace Banking\Domain\ValueObject;

use CORE\Domain\ValueObject\State;

/**
 * @todo adjust this definition
 */
final class BankState extends State
{
    private function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function ENABLED(): self
    {
        return new self(
            value: 'enabled',
        );
    }

    public static function DISABLED(): self
    {
        return new self(
            value: 'disabled',
        );
    }

    /**
     * Summary of getAllowed.
     *
     * @return BankState[]
     */
    public static function getAllowed(): array
    {
        return [
            self::ENABLED(),
            self::DISABLED(),
        ];
    }
}
