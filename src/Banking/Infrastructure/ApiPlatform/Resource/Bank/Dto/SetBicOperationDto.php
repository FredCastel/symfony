<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class SetBicOperationDto
{
    public ?string $bic;
    #[NotNull()]
    public string $name;
    public ?string $url;
}
