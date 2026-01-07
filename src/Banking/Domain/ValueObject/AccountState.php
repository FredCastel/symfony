<?php

namespace Banking\Domain\ValueObject;

use Core\Domain\ValueObject\State;

/**
 * @todo adjust this definition
 */
final class AccountState extends State
{
    public const DRAFT = 'draft';
    public const OPENED = 'opened';
    public const CLOSED = 'closed';

    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function DRAFT(): self
    {
        return new self(
            value: self::DRAFT,
        );
    }

    public static function OPENED(): self
    {
        return new self(
            value: self::OPENED,
        );
    }

    public static function CLOSED(): self
    {
        return new self(
            value: self::CLOSED,
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
