<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class SetUrlOperationDto
{
    public ?string $url = null;
    #[NotNull()]
    public string $name;
    public ?string $bic = null;
}
