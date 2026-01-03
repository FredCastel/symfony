<?= "<?php\n" ?>
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */
 
namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

abstract class <?= str_replace('final', '', $class_data->getClassName()) ?> implements CommandHandler
{    
    use <?= $makers->applicationCommandAggregateGetterMaker::getName($command->aggregate) ?>;
    <?php if (!$action->isInsertAction() || !$action->root): ?>
    use <?= $makers->applicationCommandEntityGetterMaker::getName($entity) ?>;
    <?php endif; ?>

    public function __construct(
        <?php if ($action->isInsertAction()): ?>
        protected IdGenerator $idGenerator,
        <?php endif; ?>
        protected <?= $makers->domainAggregateRepositoryMaker::getName($aggregate) ?> $<?= lcfirst($aggregate->name) ?>AggregateRepository,
        protected <?= $makers->domainEntityRepositoryMaker::getName($entity) ?> $<?= lcfirst($entity->name) ?>EntityRepository,
    ) {
    }

    public function listenTo(): string
    {
        return <?= $makers->applicationCommandRequestMaker::getName($command) ?>::class;
    }

    /**
     * @param <?= $makers->applicationCommandRequestMaker::getName($command) ?> $command
     */
    public function execute(CommandRequest $command): CommandResponse
    {
        <?php if ($entity->isRoot() && $action->isInsertAction()): ?>
        $this->check(
            $command,
        );

        [$aggregate, $events] = $this->save(
            $command,
        );
        <?php else: ?>
        $aggregate = $this->require<?= $aggregate->name ?>Aggregate($command->id);
        //$entity = $this->require<?= $entity->name ?>Entity($command->id);
        
        $this->check(
            $aggregate,
            $command,
        );

        [$aggregate, $events] = $this->save(
            $aggregate,
            $command,
        );
        <?php endif; ?>
        
        $validator = new AggregateValidator();
        $validator->validate($aggregate);

        $this-><?= lcfirst($aggregate->name) ?>AggregateRepository->save($aggregate, $events);

        return CommandResponse::withEvents($events);
    }

    abstract protected function check(
        <?php if (!($entity->isRoot() && $action->isInsertAction())): ?>
        <?= $makers->domainAggregateMaker::getName($aggregate) ?> $aggregate,
        <?php endif; ?>
        <?= $makers->applicationCommandRequestMaker::getName($command) ?> $command,
    ): void;

    abstract protected function save(
        <?php if (!($entity->isRoot() && $action->isInsertAction())): ?>
        <?= $makers->domainAggregateMaker::getName($aggregate) ?> $aggregate,
        <?php endif; ?>
        <?= $makers->applicationCommandRequestMaker::getName($command) ?> $command,
    ): array;
}