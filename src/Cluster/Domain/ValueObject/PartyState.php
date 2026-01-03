<?php

namespace Cluster\Domain\ValueObject;

use CORE\Domain\ValueObject\State;

/**
 * @todo adjust this definition
 */
final class PartyState extends State
{
    private function __construct(
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
     * @return PartyState[]
     */
    public static function getAllowed(): array
    {
        return [
            self::DRAFT(),
            self::ENABLED(),
            self::DISABLED(),
        ];
    }
}
