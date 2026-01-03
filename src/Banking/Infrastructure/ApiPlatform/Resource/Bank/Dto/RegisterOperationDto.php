<?php

namespace Banking\Infrastructure\ApiPlatform\Resource\Bank\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RegisterOperationDto
{
    #[NotNull()]
    public string $entity_id;
    #[NotNull()]
    public string $name;
    #[NotNull()]
    public string $country;
    #[NotNull()]
    public string $url;
    #[NotNull()]
    public string $bic;
}
