<?php

namespace Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RegisterLegalOperationDto
{
    #[NotNull()]
    public string $name;
    public ?string $url = null;
}
