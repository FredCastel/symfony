<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class SetUrlOperationDto
{
    public ?string $url;
    #[NotNull()]
    public string $name;
    public ?string $bic;
}
