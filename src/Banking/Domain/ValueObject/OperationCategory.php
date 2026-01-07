<?php

namespace Banking\Domain\ValueObject;

use Core\Domain\ValueObject\Category;

/**
 * @todo adjust this definition
 */
final class OperationCategory extends Category
{
    public const COMING = 'coming';
    public const SAVED = 'saved';

    public function __construct(
        string $value,
    ) {
        parent::__construct($value);
    }

    public static function COMING(): self
    {
        return new self(
            value: self::COMING,
        );
    }

    public static function SAVED(): self
    {
        return new self(
            value: self::SAVED,
        );
    }

    /**
     * Summary of getAllowed.
     *
     * @return OperationCategory[]
     */
    public static function getAllowed(): array
    {
        return [
            self::COMING(),
            self::SAVED(),
        ];
    }
}
