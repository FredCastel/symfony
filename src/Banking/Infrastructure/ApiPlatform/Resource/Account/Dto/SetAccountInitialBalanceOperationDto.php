<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class SetAccountInitialBalanceOperationDto
{
    #[NotNull()]
    public float $balance;
}
