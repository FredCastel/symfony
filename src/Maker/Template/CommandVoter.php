<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?>
{    
    use <?= $entity->name ?>GetterTrait;

    public function __construct(
        private <?= $makers->domainEntityRepositoryMaker::getName($entity) ?> $<?= lcfirst($entity->name) ?>Repository,
    ) {
    }

    public function listenTo(): string
    {
        return <?= $makers->applicationCommandRequestMaker::getName($command) ?>::class;
    }

    protected function internalVoter($id): void
    {
        /**
         * @var <?= $makers->domainEntityMaker::getName($entity)  . "\n" ?>
         */
        <?php if(!$action->isInsertAction()): ?>
        $entity = $this-><?= lcfirst($entity->name) ?>Repository->get($id);
        if (!$entity->can<?= ucfirst($action->name) ?>()) {
            $notif = new Notification();
            $notif->addMessage(new InformationMessage("<?= $command->name ?>", "Command can't be applied"));
            throw new CommandVoterException($notif);
        }
        <?php endif; ?>        
    }
}