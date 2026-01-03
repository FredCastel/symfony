<?php

namespace Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class RegisterNaturalOperationDto
{
    #[NotNull()]
    public string $entity_id;
    #[NotNull()]
    public string $name;
    #[NotNull()]
    public string $address;
}
