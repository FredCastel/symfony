<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

interface <?= $class_data->getClassName() ?> extends Dependency
{
public function used<?= $entity->name ?>(<?= $makers->domainEntityMaker::getName($entity) ?> $model): bool;

}