<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

/**
* <?= $entity->description ?>
* @todo apply necessary rules and changes
*/
<?= $class_data->getClassDeclaration() ?> 
{

    /************* Events Applier */

    <?php foreach ($entity->actions as $action): ?>
    public function apply<?= $action->eventName ?>(<?= $makers->domainEventMaker::getName($action) ?> $event): <?= $makers->domainEntityMaker::getName($entity) ?>
    {
        $instance = parent::apply<?= $action->eventName ?>($event);

        //TODO manage custom rules when necessary

        return $instance;
    }    
    <?php endforeach; ?>

    /************* Children Entities Events Applier */

    <?php foreach ($entity->entities as $child): ?>
    <?php foreach ($child->actions as $action): ?>
    public function apply<?= $action->eventName ?>(<?= $makers->domainEventMaker::getName($action) ?> $event): <?= $makers->domainEntityMaker::getName($entity) ?>
    {
        $instance = parent::apply<?= $action->eventName ?>($event);

        //TODO manage custom rules when necessary

        <?php if ($action->hasFreeParameter()): ?>
        //mapping parameters without any link (generator could not apply an atomatic mapping rule)
        <?php foreach ($action->parameters as $parameter): ?>
        <?php if ($parameter->withoutLink()): ?>
        //TODO manage event-><?= $parameter->name."\n"?> 
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>

        return $instance;
    }
    <?php endforeach; ?>
    <?php endforeach; ?>    

    /************* Functionnal methods */

    /**
    * check if the entity can be used / modify
    * @return bool
    */
    public function isUsabled(): bool
    {
        //TODO implement usage rules
        return true;
    }

    /************* Voter */

    <?php foreach ($entity->actions as $action): ?>
    <?php if(!$action->isInsertAction()): ?>        
    /**
    * check if the action "<?= $action->name ?>" can be applied on entity
    * this check is done before appling any the action
    * can be used to list the allowed action on an instance of the <?= $entity->name ?> entity 
    * @return bool
    */
    public function can<?= ucfirst($action->name) ?>(): bool
    {
        //TODO implement action voter rules
        return true;
    }
    <?php endif; ?>
    <?php endforeach; ?>

    /************* Validator */

    /**
    * check concistency of the entity    
    * @throws EntityValidationException
    */
    public function validate(): void
    {
        //TODO implement validation rules
    }

}