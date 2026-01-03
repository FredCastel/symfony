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
    protected <?= $makers->domainEntityRepositoryMaker::getName($entity) ?> $<?= lcfirst($entity->name) ?>EntityRepository;
    protected iterable $<?= lcfirst($entity->name) ?>Dependencies = [];

    public function find<?= $entity->name ?>Entity(?string $id): ?<?= $makers->domainEntityMaker::getName($entity) ?>
    {
        if ($id == null || $id == "")
            return null;

        $entity = $this-><?= lcfirst($entity->name) ?>EntityRepository->get($id);
        if ($entity == null)
            throw new CommandNotFoundEntityException("<?= $entity->name ?> entity does not exists");
        return $entity;
    }

    public function require<?= $entity->name ?>Entity(?string $id): <?= $makers->domainEntityMaker::getName($entity) ?>
    {
        if ($id == null || $id == "")
            throw new CommandRequiredEntityException("<?= $entity->name ?> is required");
        return $this->Find<?= $entity->name ?>Entity($id);
    }

    public function is<?= $entity->name ?>Used(?<?= $entity->name ?> $entity): bool
    {
        if ($entity == null)
            return false;

        foreach ($this-><?= lcfirst($entity->name) ?>Dependencies as $dependency) {
            if ($dependency->used<?= $entity->name ?>($entity))
                return true;
        }
        return false;
    }
}