<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

#[ApiResource(
    shortName: '<?= $resource->name ?>',
    stateOptions: new Options(entityClass: <?= $doctrineEntityMaker::getName($entity) ?>::class),
    operations: [
        //getter
        new GetCollection(
            name: '_api_/<?= ($resource->parent_resource)?($resource->parent_resource->api_path.'/{parent_id}/'):null ?><?= $resource->api_path ?>/list',
            uriTemplate: '/<?= ($resource->parent_resource)?($resource->parent_resource->api_path.'/{parent_id}/'):null ?><?= $resource->api_path ?>/list',
            <?php if($resource->parent_resource): ?>
            uriVariables: [
                'parent_id' => new Link(fromClass: <?= $resource->parent_resource->name ?>Resource::class, toProperty: '<?= $resource->target_entity->target_root_relation->name ?>'),
            ],
            <?php endif; ?>
            provider: <?= $apiCollectionProviderMaker::getName($resource,'','List') ?>::class,
            output: <?= $apiResourceListDtoMaker::getName($resource) ?>::class,
        ),
        new GetCollection(
            name: '_api_/<?= ($resource->parent_resource)?($resource->parent_resource->api_path.'/{parent_id}/'):null ?><?= $resource->api_path ?>',
            uriTemplate: '/<?= ($resource->parent_resource)?($resource->parent_resource->api_path.'/{parent_id}/'):null ?><?= $resource->api_path ?>',
            <?php if($resource->parent_resource): ?>
            uriVariables: [
                'parent_id' => new Link(fromClass: <?= $resource->parent_resource->name ?>Resource::class, toProperty: '<?= $resource->target_entity->target_root_relation->name ?>'),
            ],
            <?php endif; ?>
            normalizationContext: ['iri_only' => true],
            itemUriTemplate: '/<?= $resource->api_path ?>/{id}',
            provider: <?= $apiCollectionProviderMaker::getName($resource) ?>::class,
        ),
        new GetCollection(
            name: '_api_/<?= ($resource->parent_resource)?($resource->parent_resource->api_path.'/{parent_id}/'):null ?><?= $resource->api_path ?>/allowed',
            uriTemplate: '/<?= ($resource->parent_resource)?($resource->parent_resource->api_path.'/{parent_id}/'):null ?><?= $resource->api_path ?>/allowed',
            <?php if($resource->parent_resource): ?>
            uriVariables: [
                'parent_id' => new Link(fromClass: <?= $resource->parent_resource->name ?>Resource::class, toProperty: '<?= $resource->target_entity->target_root_relation->name ?>'),
            ],
            <?php endif; ?>
            input: EmptyPayload::class,
            output: AllowedResource::class,
            provider: AllowedOperationProvider::class,
        ),
        new Get(
            name: '_api_/<?= $resource->api_path ?>/{id}',
            uriTemplate: '/<?= $resource->api_path ?>/{id}',
            provider: <?= $apiItemProviderMaker::getName($resource) ?>::class,
            output: <?= $class_data->getClassName() ?>::class,
        ),
        new Get(
            name: '_api_/<?= $resource->api_path ?>/{id}/allowed',
            uriTemplate: '/<?= $resource->api_path ?>/{id}/allowed',
            input: false,
            output: AllowedResource::class,
            provider: AllowedOperationProvider::class,
        ),
        //queries
        <?php foreach ($resource->queries as $query): ?>
        new Get(
            name: '_api_/<?= $resource->api_path ?>/{id}/<?= $query->name ?>',
            uriTemplate: '/<?= $resource->api_path ?>/{id}/<?= $query->name ?>',
            input: false,
            output: <?= $apiResourceDtoMaker::getName($query) ?>::class,
            provider: <?= $apiQueryProviderMaker::getName($query) ?>::class,
        ),
        <?php endforeach; ?>
        //commands
        <?php foreach ($resource->operations as $operation): ?>
        <?php $crud = $operation->target_command->target_action->crud ?>
        new <?= $crud == 'insert' && !$operation->inherited ? 'Post' : ( $crud == 'delete' && !$operation->inherited ? 'Delete' : 'Patch' ) ?>(
            name: '_api_/<?= $resource->api_path ?>/<?= $crud != 'insert' ? '{id}/' : '' ?><?= $operation->name ?>',
            uriTemplate: '<?= $resource->api_path ?>/<?= $crud != 'insert' ? '{id}/' : '' ?><?= $operation->name ?>',
            <?php if($crud == 'insert'): ?>
            normalizationContext: ['iri_only' => true],
            <?php endif; ?>
            provider: <?= $apiItemProviderMaker::getName($resource) ?>::class,
            processor: <?= $apiProcessorMaker::getName($operation) ?>::class,
            input: <?= $operation->properties ? $apiResourceDtoMaker::getName($operation).'::class' : 'false' ?>,
            <?php if($crud != 'insert'): ?>
            output: false,            
            <?php endif; ?>
        ),  
        <?php endforeach; ?>
    ]
)]    
#[ApiFilter(
    filterClass: SearchFilter::class,
    properties: [
        'id' => 'exact',
        //'name' => 'partial',
        //'category' => 'exact',
        //'state' => 'exact',
    ])]
#[ApiFilter(
    filterClass: OrderFilter::class,
    arguments: ['orderParameterName' => '_order_'],
    properties: [
        //'name' => 'ASC',
    ])]
<?= $class_data->getClassDeclaration() ?>
{
    #[ApiProperty(identifier: true, readable: false, writable: false)]
    public string $id;

    <?php foreach ($entity->columns as $column): ?>
    public ?<?= $column->type ?> $<?= lcfirst($column->name) ?>;
    <?php endforeach; ?>

    <?php foreach ($entity->relations as $relation): ?>
    public ?<?= $relation->target_entity->target_aggregate->name ?>Resource $<?= lcfirst($relation->name) ?>;
    <?php endforeach; ?>
    
    public static function mapEntityToDto(?Doctrine<?= $entity->name ?> $entity): ?<?= $class_data->getClassName() ?>
    {
        if ($entity == null)
            return null;

        $dto = new self();
        $dto->id = $entity->getId()->__toString();
        <?php foreach ($entity->columns as $column): ?>
        $dto-><?= $column->name ?> = $entity->get<?= lcfirst($column->name) ?>();
        <?php endforeach; ?>
        <?php foreach ($entity->relations as $relation): ?>
        $dto-><?= $relation->name ?> = <?= $relation->target_entity->target_aggregate->name ?>Resource::mapEntityToDto($entity->get<?= $relation->target_entity->target_aggregate->name ?>());
        <?php endforeach; ?>

        return $dto;
    }
}