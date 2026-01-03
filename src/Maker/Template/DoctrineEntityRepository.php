<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?> implements <?= $makers->domainEntityRepositoryMaker::getName($entity) ?>
{
    public function __construct(
        ManagerRegistry $registry,
        <?= $makers->domainAggregateRepositoryMaker::getName($entity->aggregate) ?> $aggregateRepository,
    ) {
        parent::__construct($registry, $aggregateRepository);
    }

    public function getEntityClass(): string
    {
        return <?= $makers->domainEntityMaker::getName($entity) ?>::class;
    }

    public function getDoctrineEntityClass(): string
    {
        return <?= $makers->doctrineEntityMaker::getName($resource) ?>::class;
    }

    <?php foreach ($resource->associations as $association): ?>
    public function used<?= $association->getTargetRelation()->getTargetEntity()->name ?>(<?= $makers->domainEntityMaker::getName($association->getTargetRelation()->getTargetEntity()) ?> $entity): bool
    {
        $mapper = new <?= $makers->doctrineMapperMaker::getName($association->getTargetResource()) ?>();

        $entityClass = $mapper->getDoctrineClass();
        $doctrineEntity = new $entityClass();
        $mapper->fromModel(doctrineEntity: $doctrineEntity, entity: $entity);

        $result = $this->findOneBy(['<?= $association->getTargetResource()->name ?>' => $doctrineEntity]);

        return $result ? true : false;
    }
    <?php endforeach; ?>

}