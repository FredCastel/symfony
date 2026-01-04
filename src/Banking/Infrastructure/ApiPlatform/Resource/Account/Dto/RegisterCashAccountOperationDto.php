<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RegisterCashAccountOperationDto
{
    #[NotNull()]
    public string $name;
    #[NotNull()]
    public string $currency;
    #[NotNull()]
    public string $partyId;
}
