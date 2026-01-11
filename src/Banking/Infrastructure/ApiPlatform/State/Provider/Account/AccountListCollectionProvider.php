<?php

namespace Banking\Infrastructure\ApiPlatform\State\Provider\Account;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use Banking\Infrastructure\ApiPlatform\Resource\Account\Dto\AccountListQueryDto;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class AccountListCollectionProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: CollectionProvider::class)]
        private ProviderInterface $collectionProvider,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);
        assert($entities instanceof Paginator);

        $dtos = [];

        foreach ($entities as $entity) {
            $dtos[] = AccountListQueryDto::mapEntityToDto($entity);
        }

        return new TraversablePaginator(
            new \ArrayIterator($dtos),
            $entities->getCurrentPage(),
            $entities->getItemsPerPage(),
            $entities->getTotalItems()
        );
    }
}
