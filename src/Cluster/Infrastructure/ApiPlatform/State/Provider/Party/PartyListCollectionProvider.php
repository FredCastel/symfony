<?php

namespace Cluster\Infrastructure\ApiPlatform\State\Provider\Party;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use Cluster\Infrastructure\ApiPlatform\Resource\Party\Dto\PartyListQueryDto;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class PartyListCollectionProvider implements ProviderInterface
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
            $dtos[] = PartyListQueryDto::mapEntityToDto($entity);
        }

        return new TraversablePaginator(
            new \ArrayIterator($dtos),
            $entities->getCurrentPage(),
            $entities->getItemsPerPage(),
            $entities->getTotalItems()
        );
    }
}
