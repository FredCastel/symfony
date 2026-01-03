<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Account\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RenameAccountOperationDto
{
    #[NotNull()]
    public string $entity_id;
    #[NotNull()]
    public string $name;
}
