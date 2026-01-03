<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?>
{    
    <?php foreach ($operation->getTargetCommand()->parameters as $parameter): ?>
    <?php if(!$parameter->nullable): ?>
    #[NotNull()]
    <?php endif; ?>
    public <?= $parameter->nullable ? '?' : '' ?><?= $parameter->type ?> $<?= $parameter->name ?>;
    <?php endforeach; ?>
}