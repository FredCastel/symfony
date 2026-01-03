<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

<?= $class_data->getClassDeclaration() ?>
{
    
    static function usedCommandRequests(): array
    {
        return [<?= $makers->applicationCommandRequestMaker::getName($command) ?>::class];
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        <?php if($command->getTargetAction()->isInsertAction()): ?>
        <?php if($command->parameters): ?>
        /** @var <?= $makers->apiResourceOperationDtoMaker::getName($operation) ?> */
        $input = $data;
        <?php endif; ?>
        $id = $this->idGen->next();        
        <?php else: ?>        
        Assert::isInstanceOf($context['previous_data'], <?= $makers->apiResourceMaker::getName($resource) ?>::class);
        
        <?php if($command->parameters): ?>
        /** @var <?= $makers->apiResourceOperationDtoMaker::getName($operation) ?> */
        $input = $data;
        <?php endif; ?>
        /** @var <?= $makers->apiResourceMaker::getName($resource) ?> */
        $current = $context['previous_data'];
        $id = $current->id; 
        <?php endif; ?>

        $command = new <?= $makers->applicationCommandRequestMaker::getName($command) ?>(
            id: $id,            
            <?php foreach ($command->parameters as $parameter): ?>
            <?= $parameter->name ?>: $input-><?= $parameter->name ?>,
            <?php endforeach; ?>
        );

        $this->dispatch($command);

        <?php if($command->getTargetAction()->isInsertAction()): ?>
        return $id;
        <?php endif; ?>
    }
}