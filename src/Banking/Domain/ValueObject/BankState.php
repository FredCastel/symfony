<?php

namespace Banking\Domain\ValueObject;

use Core\Domain\ValueObject\State;

/**
 * @todo adjust this definition
 */
final class BankState extends State
{
    public const ENABLED = 'enabled';
    public const DISABLED = 'disabled';

    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function ENABLED(): self
    {
        return new self(
            value: self::ENABLED,
        );
    }

    public static function DISABLED(): self
    {
        return new self(
            value: self::DISABLED,
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
