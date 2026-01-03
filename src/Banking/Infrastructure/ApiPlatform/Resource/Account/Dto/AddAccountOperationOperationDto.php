<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class AddAccountOperationOperationDto
{
    #[NotNull()]
    public string $entity_id;
    #[NotNull()]
    public string $operationDate;
    #[NotNull()]
    public string $valueDate;
    #[NotNull()]
    public float $amount;
    #[NotNull()]
    public string $label;
}
