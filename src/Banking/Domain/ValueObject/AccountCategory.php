<?php

namespace Banking\Domain\ValueObject;

use Core\Domain\ValueObject\Category;

/**
 * @todo adjust this definition
 */
final class AccountCategory extends Category
{
    public const CASH = 'cash';
    public const LIVRET = 'livret';
    public const COMPTE_A_TERME = 'compte_a_terme';
    public const ASSURANCE_VIE = 'assurance_vie';
    public const PER = 'per';
    public const PEL = 'pel';
    public const CEL = 'cel';
    public const EPARGNE = 'epargne';
    public const CB = 'cb';

    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function CASH(): self
    {
        return new self(
            value: self::CASH,
        );
    }

    public static function LIVRET(): self
    {
        return new self(
            value: self::LIVRET,
        );
    }

    public static function COMPTE_A_TERME(): self
    {
        return new self(
            value: self::COMPTE_A_TERME,
        );
    }

    public static function ASSURANCE_VIE(): self
    {
        return new self(
            value: self::ASSURANCE_VIE,
        );
    }

    public static function PER(): self
    {
        return new self(
            value: self::PER,
        );
    }

    public static function PEL(): self
    {
        return new self(
            value: self::PEL,
        );
    }

    public static function CEL(): self
    {
        return new self(
            value: self::CEL,
        );
    }

    public static function EPARGNE(): self
    {
        return new self(
            value: self::EPARGNE,
        );
    }

    public static function CB(): self
    {
        return new self(
            value: self::CB,
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
