<?php

namespace Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RegisterNaturalOperationDto
{
    #[NotNull()]
    public string $name;
    #[NotNull()]
    public string $state;
    #[NotNull()]
    public string $category;
}
