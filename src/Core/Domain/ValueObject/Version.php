<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class Version extends ValueObject
{
    readonly public int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
    protected function internalCheck(): void
    {
        Assert::that($this->value)
            ->notNull();
    }
    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
    public function isInitial(): bool
    {
        return empty($this->value);
    }
}