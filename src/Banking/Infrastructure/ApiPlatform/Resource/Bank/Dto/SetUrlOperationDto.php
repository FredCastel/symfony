<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class SetUrlOperationDto
{
    #[NotNull()]
    public string $entity_id;
    #[NotNull()]
    public string $url;
    #[NotNull()]
    public string $name;
    #[NotNull()]
    public string $bic;
}
