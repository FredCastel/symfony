<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?> implements <?= $makers->domainAggregateRepositoryMaker::getName($aggregate) ?>
{
    public function getAggregateClass(): string
    {
        return <?= $makers->domainAggregateMaker::getName($aggregate) ?>::class;
    }
}