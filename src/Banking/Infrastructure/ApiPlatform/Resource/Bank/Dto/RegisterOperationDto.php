<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RegisterOperationDto
{
    #[NotNull()]
    public string $name;
    #[NotNull()]
    public string $country;
    public ?string $url = null;
    public ?string $bic = null;
    #[NotNull()]
    public string $state;
}
