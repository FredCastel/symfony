<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

trait <?= $class_data->getClassName() ?>
{
    protected <?= $makers->domainAggregateRepositoryMaker::getName($aggregate) ?> $<?= lcfirst($aggregate->name) ?>AggregateRepository;

    public function find<?= $aggregate->name ?>Aggregate(?string $id): ?<?= $makers->domainAggregateMaker::getName($aggregate) ?>
    {
        if ($id == null || $id == "")
            return null;

        $aggregate = $this-><?= lcfirst($aggregate->name) ?>AggregateRepository->get($id);
        if ($aggregate== null)
            throw new CommandNotFoundEntityException("<?= $aggregate->name ?> aggregate does not exists");
        return $aggregate;
    }

    public function require<?= $aggregate->name ?>Aggregate(?string $id): <?= $makers->domainAggregateMaker::getName($aggregate) ?>
    {
        if ($id == null || $id == "")
            throw new CommandRequiredEntityException("<?= $aggregate->name ?> is required");
        return $this->Find<?= $aggregate->name ?>Aggregate($id);
    }
}