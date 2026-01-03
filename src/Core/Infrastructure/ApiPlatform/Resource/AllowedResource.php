<?php

declare(strict_types=1);

namespace Core\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;


#[ApiResource(
    shortName: 'Allowed',
    operations: [],
)]
final class AllowedResource
{
    public array $commands = [];
}