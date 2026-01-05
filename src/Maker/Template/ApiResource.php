<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

#[ApiResource(
    shortName: '<?= $resource->name ?>',
    stateOptions: new Options(entityClass: <?= $makers->doctrineEntityMaker::getName($entity) ?>::class),
    operations: [
        //getter
        <?php foreach ($resource->queries as $query): ?>
        <?php if($query->isCollectionQuery()): ?>
        <?php if($query->isRoot()): ?>
        new GetCollection(
            name: '_api_/<?= $resource->apiPath ?>',
            uriTemplate: '/<?= $resource->apiPath ?>',
            normalizationContext: ['iri_only' => true],
            itemUriTemplate: '/<?= $resource->apiPath ?>/{id}',
            provider: <?= $makers->apiCollectionProviderMaker::getName($resource->getRootCollectionQuery()) ?>::class,
        ),
        <?php else: ?>
        new GetCollection(
            name: '_api_/<?= $resource->apiPath ?>/<?= $query->name ?>',
            uriTemplate: '/<?= $resource->apiPath ?>/<?= $query->name ?>',
            normalizationContext: ['iri_only' => false],
            itemUriTemplate: '/<?= $resource->apiPath ?>/{id}',
            provider: <?= $makers->apiCollectionProviderMaker::getName($query) ?>::class,
        ),
        <?php endif; ?>
        <?php else: ?>        
        <?php if($query->isRoot()): ?>
        new Get(
            name: '_api_/<?= $resource->apiPath ?>/{id}',
            uriTemplate: '/<?= $resource->apiPath ?>/{id}',
            provider: <?= $makers->apiItemProviderMaker::getName($resource->getRootItemQuery()) ?>::class,
            output: <?= $class_data->getClassName() ?>::class,
        ),
        <?php else: ?>
        new Get(
            name: '_api_/<?= $resource->apiPath ?>/{id}/<?= $query->name ?>',
            uriTemplate: '/<?= $resource->apiPath ?>/{id}/<?= $query->name ?>',
            input: false,
            provider: <?= $makers->apiQueryProviderMaker::getName($query) ?>::class,
            output: <?= $makers->apiResourceDtoMaker::getName($query) ?>::class,
        ),         
        <?php endif; ?>      
        <?php endif; ?>           
        <?php endforeach; ?>
        //commands
        <?php foreach ($resource->operations as $operation): ?>
        new <?= $operation->getMethod() ?>(
            name: '_api_/<?= $resource->apiPath ?>/<?= !$operation->isInsert() ? '{id}/' : '' ?><?= $operation->name ?>',
            uriTemplate: '<?= $resource->apiPath ?>/<?= !$operation->isInsert() ? '{id}/' : '' ?><?= $operation->name ?>',
            <?php if($operation->isInsert()): ?>
            normalizationContext: ['iri_only' => true],
            <?php endif; ?>
            provider: <?= $makers->apiItemProviderMaker::getName($resource->getRootItemQuery()) ?>::class,
            processor: <?= $makers->apiProcessorMaker::getName($operation) ?>::class,
            input: <?= $operation->getTargetCommand()->parameters ? $makers->apiResourceOperationDtoMaker::getName($operation).'::class' : 'false' ?>,
            <?php if(!$operation->isInsert()): ?>
            output: false,            
            <?php endif; ?>
        ),  
        <?php endforeach; ?>
    ]
)]   
<?= $class_data->getClassDeclaration() ?>
{
    #[ApiProperty(identifier: true, readable: false, writable: false)]
    public string $id;

    <?php foreach ($resource->fields as $field): ?>
    public ?<?= $field->type ?> $<?= lcfirst($field->name) ?>;
    <?php endforeach; ?>

    <?php foreach ($resource->associations as $association): ?>
    public ?<?= $makers->apiResourceMaker::getName($association->getTargetResource()) ?> $<?= lcfirst($association->name) ?>;
    <?php endforeach; ?>

    <?php foreach ($resource->parents as $parent): ?>
    public ?<?= $makers->apiResourceMaker::getName($parent->getTargetResource()) ?> $<?= lcfirst($parent->name) ?>;
    <?php endforeach; ?>
    
    public static function mapEntityToDto(?<?= $makers->doctrineEntityMaker::getName($resource) ?> $doctrineEntity): ?<?= $class_data->getClassName() ?>
    {
        if ($doctrineEntity == null)
            return null;

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
        <?php foreach ($resource->fields as $field): ?>
        $dto-><?= $field->name ?> = $doctrineEntity->get<?= lcfirst($field->name) ?>();
        <?php endforeach; ?>
        <?php foreach ($resource->associations as $association): ?>
        $dto-><?= $association->name ?> = <?= $makers->apiResourceMaker::getName($association->getTargetResource()) ?>::mapEntityToDto($doctrineEntity->get<?= $association->name ?>());
        <?php endforeach; ?>
        <?php foreach ($resource->parents as $parent): ?>
        $dto-><?= $parent->name ?> = <?= $makers->apiResourceMaker::getName($parent->getTargetResource()) ?>::mapEntityToDto($doctrineEntity->get<?= $parent->name ?>());
        <?php endforeach; ?>
        return $dto;
    }
}