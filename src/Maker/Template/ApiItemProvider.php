<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?> implements ProviderInterface
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
        <?php if($query->isRoot()): ?>
        return <?= $makers->apiResourceMaker::getName($query->resource) ?>::mapEntityToDto($entity);
        <?php else: ?>
        return <?= $makers->apiResourceQueryDtoMaker::getName($query) ?>::mapEntityToDto($entity);
        <?php endif; ?>
    }
}