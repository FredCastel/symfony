<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?> implements CommandRequest
{
    public function __construct(
        public string $id,
        <?php foreach ($command->parameters as $parameter): ?>
        <?php if ($parameter->isConstant()) continue; ?>
        public <?= $parameter->nullable ? '?' : '' ?><?= $parameter->type ?> $<?= $parameter->name ?><?= $parameter->nullable ? ' = null' : '' ?>,
        <?php endforeach; ?>
    ) {
    }
}