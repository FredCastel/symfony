<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= str_replace('final class', 'interface', $class_data->getClassDeclaration()) ?>
{
    /**
    * @return <?= $makers->domainEntityMaker::getName($entity) ?><?= "\n" ?>
    */
    public function get(string $id): Entity;

    <?php foreach ($entity->relations as $relation): ?>
    public function used<?= $relation->getTargetEntity()->name ?>(<?= $makers->domainEntityMaker::getName($relation->getTargetEntity()) ?> $model): bool;
    <?php endforeach; ?>
}