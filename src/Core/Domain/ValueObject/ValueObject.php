<?php
namespace Core\Domain\ValueObject;

use Core\Service\Assert\AssertionFailedException;


abstract class ValueObject implements \JsonSerializable
{
    abstract protected function internalCheck(): void;

    public function check(): void
    {
        try {
            $this->internalCheck();
        } catch (AssertionFailedException $e) {
            throw new ValueObjectException($e->getMessage(), $e->getCode(), $e);

        }
    }
    abstract public function isInitial(): bool;
}