<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class LifeCycle extends ValueObject
{
    private DateTime $createdAt;
    private ?DateTime $changedAt;

    public function __construct(?DateTime $createdAt = null, ?DateTime $changedAt = null)
    {
        $this->createdAt = $createdAt ? $createdAt : new DateTime('now');
        $this->changedAt = $changedAt ? $changedAt : null;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getChangedAt(): ?DateTime
    {
        return $this->changedAt;
    }

    /**
     * @return self
     */
    public function setChanged(): self
    {
        $this->changedAt = new DateTime('now');
        return $this;
    }
    protected function internalCheck(): void
    {
        Assert::that($this->changedAt)
            ->nullOr()
            ->greaterOrEqualThan($this->createdAt);
    }
    public function __toString()
    {
        return (string) $this->createdAt . "-" . $this->changedAt;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'createdAt' => json_encode($this->createdAt),
            'changedAt' => json_encode($this->changedAt),
        ];
    }
    public function isInitial(): bool
    {
        return $this->createdAt->isInitial() && $this->changedAt->isInitial();
    }
}