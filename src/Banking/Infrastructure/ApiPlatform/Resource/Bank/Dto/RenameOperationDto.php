<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RenameOperationDto
{
    #[NotNull()]
    public string $name;
    public ?string $url;
    public ?string $bic;
}
