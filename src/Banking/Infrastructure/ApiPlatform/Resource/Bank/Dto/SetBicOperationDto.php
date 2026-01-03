<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class SetBicOperationDto
{
    #[NotNull()]
    public string $entity_id;
    #[NotNull()]
    public string $bic;
    #[NotNull()]
    public string $name;
    #[NotNull()]
    public string $url;
}
