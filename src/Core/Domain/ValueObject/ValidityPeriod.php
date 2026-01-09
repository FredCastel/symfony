<?php

namespace Core\Domain\ValueObject;

use Core\Service\Assert\Assert;

class ValidityPeriod extends ValueObject
{
    const initialSinceDate = "1990-01-01T00:00:00+00:00";
    const initialUntilDate = "2999-12-31T00:00:00+00:00";

    readonly public DateTime $since;
    readonly public DateTime $until;

    public function __construct(
        ?DateTime $since = null,
        ?DateTime $until = null
    ) {
        $this->since = $since ?? new DateTime(self::initialSinceDate);
        $this->until = $until ?? new DateTime(self::initialUntilDate);
    }

    public function isInitial(): bool
    {
        return
            $this->since->value === self::initialSinceDate &&
            $this->until->value === self::initialUntilDate;
    }

    public function getSince(): DateTime
    {
        return $this->since;
    }

    public function setSince(DateTime $since): self
    {
        $this->since = $since;
        return $this;
    }

    public function getUntil(): DateTime
    {
        return $this->until;
    }

    public function setUntil(DateTime $until): self
    {
        $this->until = $until;
        return $this;
    }

    public function dateInPeriod(DateTime $dateToCheck): bool
    {
        return $this->since <= $dateToCheck && $dateToCheck <= $this->until;
    }

    protected function internalCheck(): void
    {
        Assert::that($this->since)
            ->lessOrEqualThan($this->until);
    }

    public function __toString()
    {
        return (string) $this->since . "-" . $this->until;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'createdAt' => json_encode($this->since),
            'changedAt' => json_encode($this->until),
        ];
    }
}