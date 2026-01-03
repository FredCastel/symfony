<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class CloseAccountOperationDto
{
    #[NotNull()]
    public string $entity_id;
}
