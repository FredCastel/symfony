<?php

namespace Banking\Domain\ValueObject;

use Core\Domain\ValueObject\State;

/**
 * @todo adjust this definition
 */
final class AccountState extends State
{
    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function DRAFT(): self
    {
        return new self(
            value: 'draft',
        );
    }

    public static function OPENED(): self
    {
        return new self(
            value: 'opened',
        );
    }

    public static function CLOSED(): self
    {
        return new self(
            value: 'closed',
        );
    }

    /**
     * Summary of getAllowed.
     *
     * @return AccountState[]
     */
    public static function getAllowed(): array
    {
        return [
            self::DRAFT(),
            self::OPENED(),
            self::CLOSED(),
        ];
    }
}
