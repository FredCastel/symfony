<?php

namespace Cluster\Domain\ValueObject;

use Core\Domain\ValueObject\Category;

/**
 * @todo adjust this definition
 */
final class PartyCategory extends Category
{
    public const NATURAL = 'natural';
    public const LEGAL = 'legal';

    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function NATURAL(): self
    {
        return new self(
            value: self::NATURAL,
        );
    }

    public static function LEGAL(): self
    {
        return new self(
            value: self::LEGAL,
        );
    }

    /**
     * Summary of getAllowed.
     *
     * @return PartyCategory[]
     */
    public static function getAllowed(): array
    {
        return [
            self::NATURAL(),
            self::LEGAL(),
        ];
    }
}
