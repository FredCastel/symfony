<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?>
{
    /**
     * Summary of __construct
    <?php foreach ($resource->associations as $association): ?>
    * @param <?= $makers->doctrineEntityRepositoryMaker::getName($association->getTargetResource()) ?>
    <?php endforeach; ?>
     */
    public function __construct(
        <?php foreach ($resource->associations as $association): ?>
        private <?= $makers->doctrineEntityRepositoryMaker::getName($association->getTargetResource()) ?> $<?= $association->name ?>Repository,
        <?php endforeach; ?>
    ) {
    }

    public function getAggregateClass(): string
    {
        return <?= $makers->domainAggregateMaker::getName($entity->aggregate) ?>::class;
    }
    public function getEntityClass(): string
    {
        return <?= $makers->domainEntityMaker::getName($entity) ?>::class;
    }
    public function getDoctrineEntityClass(): string
    {
        return <?= $makers->doctrineEntityMaker::getName($resource) ?>::class;
    }

    /**
     * convert Model to Doctrine Entity
     * @param <?= $makers->doctrineEntityMaker::getName($resource) ?> $doctrineEntity
     * @param <?= $makers->domainEntityMaker::getName($entity) ?> $entity
     * @return <?= $makers->doctrineEntityMaker::getName($resource) ?><?= "\n" ?>
     */
    public function fromModel(?DoctrineEntity $doctrineEntity, ?Entity $entity): ?DoctrineEntity
    {
        if ($entity == null)
            return null;

        $doctrineEntity
            ->setId(Uuid::fromString($entity->getId()->value))
            <?php foreach ($resource->fields as $field): ?>
            <?php if($field->getTargetProperty()->nullable): ?>
            ->set<?= ucfirst($field->name) ?>($entity->get<?= ucfirst($field->getTargetProperty()->name) ?>() ? <?= $field->convertToPhp() ?>($entity->get<?= $field->getTargetProperty()->name ?>()-><?= $field->getTargetPropertyinput()->name ?>) : null)
            <?php else: ?>
            ->set<?= ucfirst($field->name) ?>(<?= $field->convertToPhp() ?>($entity->get<?= ucfirst($field->getTargetProperty()->name) ?>()-><?= $field->getTargetPropertyinput()->name ?>))
            <?php endif; ?>
            <?php endforeach; ?>
        ;     

        <?php foreach ($resource->associations as $association): ?>
        //<?= $association->getTargetRelation()->name ?> relation
        if ($entity->get<?= ucfirst($association->getTargetRelation()->name) ?>()) {
            $<?= lcfirst($association->getTargetRelation()->getTargetEntity()->name) ?>Entity = $this-><?= $association->name ?>Repository->find(id: Uuid::fromString($entity->get<?= ucfirst($association->getTargetRelation()->name) ?>()->value));
            $doctrineEntity->set<?= ucfirst($association->name) ?>($<?= lcfirst($association->getTargetRelation()->getTargetEntity()->name) ?>Entity);
        } else {
            $doctrineEntity->set<?= ucfirst($association->name) ?>(null);
        }

        <?php endforeach; ?>

        return $doctrineEntity;
    }
}