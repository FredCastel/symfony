<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class DisableOperationDto
{
    #[NotNull()]
    public string $entity_id;
}
