<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RemoveOperationDto
{
    #[NotNull()]
    public string $entity_id;
}
