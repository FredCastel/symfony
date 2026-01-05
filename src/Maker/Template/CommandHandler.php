<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?> implements CommandHandler
{
    protected function check(
        <?php if (!($entity->isRoot() && $action->isInsertAction())): ?>
        <?= $makers->domainAggregateMaker::getName($aggregate) ?> $aggregate,
        <?php endif; ?>
        <?= $makers->applicationCommandRequestMaker::getName($command) ?> $command,
    ):void{
        //TODO some checks
    }

    protected function save(
        <?php if (!($entity->isRoot() && $action->isInsertAction())): ?>
        <?= $makers->domainAggregateMaker::getName($aggregate) ?> $aggregate,
        <?php endif; ?>
        <?= $makers->applicationCommandRequestMaker::getName($command) ?> $command,
    ): array 
    {
        <?php if ($entity->isRoot() && $action->isInsertAction()): ?>
        [$aggregate, $events] = (new <?= $makers->domainAggregateMaker::getName($aggregate) ?>(new Id($command->id)))->getRoot()-><?= lcfirst($action->name) ?>(
        <?php else: ?>
        [$aggregate, $events] = $aggregate->getRoot()-><?= $action->name ?>(
        <?php endif; ?>
            entity_id: $command->entity_id,
            <?php foreach ($action->parameters as $parameter): ?>
            <?php $p = $command->getParameterForActionparameter($parameter); ?>
            <?php if ($p): ?>
            <?= $parameter->name ?>: $command-><?= $p->name ?>,
            <?php else: ?>
            <?php if ($parameter->nullable): ?>
            <?= $parameter->name ?>: null,
            <?php else: ?>
            <?= $parameter->name ?>: 'todo',//TODO mapping rule
            <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; ?>
        );

        return [$aggregate, $events];
    }
}