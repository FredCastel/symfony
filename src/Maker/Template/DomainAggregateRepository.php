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
    * @param <?= $makers->domainAggregateMaker::getName($aggregate) ?> $aggregate
    */
    public function save(Aggregate $aggregate, array $events): void;

    /**
    * @return <?= $makers->domainAggregateMaker::getName($aggregate) ?><?= "\n" ?>
    */
    public function get(string $id): Aggregate;
}