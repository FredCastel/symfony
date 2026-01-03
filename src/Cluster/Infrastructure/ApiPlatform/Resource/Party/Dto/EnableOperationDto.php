<?php

namespace Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto;

use Symfony\Component\Validator\Constraints\NotNull;

final class EnableOperationDto
{
    #[NotNull()]
    public string $entity_id;
}
