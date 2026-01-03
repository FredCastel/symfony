<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RegisterBankAccountOperationDto
{
    #[NotNull()]
    public string $entity_id;
    #[NotNull()]
    public string $name;
    #[NotNull()]
    public string $currency;
    #[NotNull()]
    public string $partyId;
    #[NotNull()]
    public string $bankId;
}
