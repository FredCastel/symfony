<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RemoveAccountOperationOperationDto
{
    #[NotNull()]
    public string $entity_id;
}
