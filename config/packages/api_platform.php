<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Webmozart\Assert\InvalidArgumentException;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('api_platform', [
        'mapping' => [
            'paths' => [
                '%kernel.project_dir%/src/Banking/Infrastructure/ApiPlatform/Resource/',
                // '%kernel.project_dir%/src/Banking/Infrastructure/Doctrine/Entity/',
                '%kernel.project_dir%/src/Cluster/Infrastructure/ApiPlatform/Resource/',
                // '%kernel.project_dir%/src/Cluster/Infrastructure/Doctrine/Entity/',
                // '%kernel.project_dir%/src/Business/Infrastructure/ApiPlatform/Resource/',
                // '%kernel.project_dir%/src/Business/Infrastructure/Doctrine/Entity/',
            ],
        ],
        'patch_formats' => [
            'json' => ['application/merge-patch+json'],
        ],
        'swagger' => [
            'versions' => [3],
        ],
        'defaults' => [
            //https://api-platform.com/docs/core/pagination/
            'pagination_client_enabled' => true,
            'pagination_client_items_per_page' => true,
            'pagination_partial' => false,
            // Disabled by default
            'pagination_client_partial' => true,
        ],
        'exception_to_status' => [
                // TODO
                // We must trigger the API Platform validator before the data transforming.
                // Let's create an API Platform PR to update the AbstractItemNormalizer.
                // In that way, this exception won't be raised anymore as payload will be validated (see DiscountBookPayload).
            InvalidArgumentException::class => 422,
        ],
    ]);
};