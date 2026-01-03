<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class SetAccountBalanceLimitsOperationDto
{
    #[NotNull()]
    public string $entity_id;
    #[NotNull()]
    public float $minimum;
    #[NotNull()]
    public float $maximum;
}
