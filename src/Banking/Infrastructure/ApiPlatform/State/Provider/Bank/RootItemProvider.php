<?php

namespace Banking\Infrastructure\ApiPlatform\State\Provider\Bank;

use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Banking\Infrastructure\ApiPlatform\Resource\Bank\BankResource;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class RootItemProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: ItemProvider::class)]
        private ProviderInterface $itemProvider,
        protected EntityManagerInterface $em,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entity = $this->itemProvider->provide($operation, $uriVariables, $context);

        if (!$entity) {
            return null;
        }

        return BankResource::mapEntityToDto($entity);
    }
}
