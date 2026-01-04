<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?> 
{
    public function __construct(
        <?= $makers->doctrineAggregateRepositoryMaker::getName($entity->aggregate) ?> $aggregateRepository,
        <?= $makers->doctrineEntityRepositoryMaker::getName($resource) ?> $repo,
        <?= $makers->doctrineMapperMaker::getName($resource) ?> $mapper,
        EntityManagerInterface $em
    ) {
        parent::__construct($aggregateRepository, $repo, $mapper, $em);
    }
    
    public function listenTo(): iterable
    {
        <?php if($actions):?>
        <?php foreach ($actions as $action): ?>
        yield <?= $makers->domainEventMaker::getName($action) ?>::class; 
        <?php endforeach; ?>
        <?php else: ?>
        return [];
        <?php endif; ?>
    }
}