<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RenameBankOperationDto
{
    #[NotNull()]
    public string $name;
}
