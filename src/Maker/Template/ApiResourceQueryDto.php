<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>


#[Get(
    shortName: '<?= $resource->getTargetEntity()->name ?>',
)]    
<?= $class_data->getClassDeclaration() ?>
{
    public string $id;

    <?php foreach ($query->outputs as $output): ?>
    <?php if ($output->kind =='field'): ?>
    public ?<?= $output->type ?> $<?= lcfirst($output->name) ?>;
    <?php elseif($output->kind =='association'): ?>
    //public ?<?= $makers->apiResourceMaker::getName($output->getTargetResource()) ?> $<?= lcfirst($output->name) ?>;
    <?php elseif($output->kind =='parent'): ?>
    //public ?<?= $makers->apiResourceMaker::getName($output->getTargetResource()) ?> $<?= lcfirst($output->name) ?>;
    <?php endif; ?>   
    <?php endforeach; ?>
    
    public static function mapEntityToDto(?<?= $makers->doctrineEntityMaker::getName($resource) ?> $doctrineEntity): ?<?= $class_data->getClassName() ?>
    {
        if ($doctrineEntity == null)
            return null;

        $dto = new self();
        $dto->id = $doctrineEntity->getId()->__toString();
        <?php foreach ($query->outputs as $output): ?>
        <?php if ($output->kind =='field'): ?>
        $dto-><?= $output->name ?> = $doctrineEntity->get<?= lcfirst($output->name) ?>();
        <?php elseif($output->kind =='association'): ?>
        //$dto-><?= $output->name ?> = <?= $makers->apiResourceMaker::getName($output->getTargetResource()) ?>::mapEntityToDto($doctrineEntity->get<?= $output->name ?>());
        <?php elseif($output->kind =='parent'): ?>
        //$dto-><?= $output->name ?> = <?= $makers->apiResourceMaker::getName($output->getTargetResource()) ?>::mapEntityToDto($doctrineEntity->get<?= $output->name ?>());
        <?php endif; ?>  
        <?php endforeach; ?>
        return $dto;
    }    
}