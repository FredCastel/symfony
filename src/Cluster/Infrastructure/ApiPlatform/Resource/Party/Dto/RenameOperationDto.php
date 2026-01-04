<?php

namespace Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RenameOperationDto
{
    #[NotNull()]
    public string $name;
}
