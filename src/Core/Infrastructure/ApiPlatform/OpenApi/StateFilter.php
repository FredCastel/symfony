<?php

declare(strict_types=1);

namespace Core\Infrastructure\ApiPlatform\OpenApi;

use ApiPlatform\Api\FilterInterface;
use Symfony\Component\PropertyInfo\Type;

final class StateFilter implements FilterInterface
{
    public function getDescription(string $resourceClass): array
    {
        return [
            'state' => [
                'property' => 'state',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'is_collection' => true,
                'openapi' => [
                    'description' => 'My Description',
                    'name' => 'My Name',
                    'schema' => [
                        'type' => 'integer',
                    ]
                ],
                'schema' => [
                    'type' => 'string',
                    'enum' => ['value_1', 'value_2'],
                ],
                'swagger' => [
                    'description' => 'My Description',
                    'name' => 'My Name',
                    'type' => 'integer',
                ]
            ],
        ];
    }
}