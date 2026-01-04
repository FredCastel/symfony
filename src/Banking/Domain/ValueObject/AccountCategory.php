<?php

namespace Banking\Domain\ValueObject;

use Core\Domain\ValueObject\Category;

/**
 * @todo adjust this definition
 */
final class AccountCategory extends Category
{
    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function CASH(): self
    {
        return new self(
            value: 'cash',
        );
    }

    public static function LIVRET(): self
    {
        return new self(
            value: 'livret',
        );
    }

    public static function COMPTE_A_TERME(): self
    {
        return new self(
            value: 'compte_a_terme',
        );
    }

    public static function ASSURANCE_VIE(): self
    {
        return new self(
            value: 'assurance_vie',
        );
    }

    public static function PER(): self
    {
        return new self(
            value: 'per',
        );
    }

    public static function PEL(): self
    {
        return new self(
            value: 'pel',
        );
    }

    public static function CEL(): self
    {
        return new self(
            value: 'cel',
        );
    }

    public static function EPARGNE(): self
    {
        return new self(
            value: 'epargne',
        );
    }

    public static function CB(): self
    {
        return new self(
            value: 'cb',
        );
    }

    /**
     * Summary of getAllowed.
     *
     * @return AccountCategory[]
     */
    public static function getAllowed(): array
    {
        return [
            self::CASH(),
            self::LIVRET(),
            self::COMPTE_A_TERME(),
            self::ASSURANCE_VIE(),
            self::PER(),
            self::PEL(),
            self::CEL(),
            self::EPARGNE(),
            self::CB(),
        ];
    }
}
