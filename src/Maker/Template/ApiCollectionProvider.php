<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?> implements ProviderInterface
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
            <?php if($query->isRoot()): ?>
            $dtos[] = <?= $makers->apiResourceMaker::getName($query->resource) ?>::mapEntityToDto($entity);
            <?php else: ?>
            $dtos[] = <?= $makers->apiResourceQueryDtoMaker::getName($query) ?>::mapEntityToDto($entity);
            <?php endif; ?>
        }

        return new TraversablePaginator(
            new \ArrayIterator($dtos),
            $entities->getCurrentPage(),
            $entities->getItemsPerPage(),
            $entities->getTotalItems()
        );
    }
}