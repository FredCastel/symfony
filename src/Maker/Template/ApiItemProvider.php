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

        return <?= $makers->apiResourceQueryDtoMaker::getName($query) ?>::mapEntityToDto($entity);
    }
}