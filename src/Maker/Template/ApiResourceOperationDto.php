<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?>
{    
    <?php foreach ($operation->getParameters() as $parameter): ?>
    <?php if(!$parameter->nullable): ?>
    #[NotNull()]
    <?php endif; ?>
    public <?= $parameter->nullable ? '?' : '' ?><?= $parameter->type ?> $<?= $parameter->name ?><?= $parameter->nullable ? ' = null' : '' ?>;
    <?php endforeach; ?>
}