<?= "<?php\n" ?>

namespace <?= $ns ?>;

<?= $class_data->getUseStatements(); ?>

/**
* <?= $entity->description ?>
* @generated This class is generated and updated by the maker, do not modify it manually.
*/
abstract <?= str_replace('final', '', $class_data->getClassDeclaration()) ?>
{
    /**
    * Aggregate  <?= $entity->aggregate->description ?> 
    * @var <?= $makers->domainAggregateMaker::getName($entity->aggregate) ?>
    */ 
    protected Aggregate $aggregate;
    <?php if ($entity->isChild()): ?>  

    /**
    * Parent Entity  <?= $entity->parent->description ?> 
    * @var <?= $makers->domainEntityMaker::getName($entity->parent) ?>
    */ 
    protected Entity $parent;
    <?php endif; ?>

    /************* Entity Properties */

    <?php foreach ($entity->properties as $property): ?>
    <?php if(!$property->isId()): ?>
    /**
    * <?= $property->description ?> 
    */ 
    protected <?= $property->nullable ? '?' : '' ?><?= $property->valueObject->name ?> $<?= $property->name ?><?= $property->nullable ? ' = null' : '' ?>;
    <?php endif; ?>
    <?php endforeach; ?>

    /************* Entity Relations */
    
    <?php foreach ($entity->relations as $relation): ?>
    /**
    * <?= $relation->description ?> 
    */ 
    protected <?= $relation->nullable ? '?' : '' ?><?= $relation->valueObject->name ?> $<?= $relation->name ?>;
    <?php endforeach; ?>    
    
    /************* Children Entities */
    
    <?php foreach ($entity->entities as $child): ?>
    <?php if($child->isOne()): ?>
    protected <?= $child->nullable ? '?' : '' ?><?= $makers->domainEntityMaker::getName($child) ?> $<?= $child->propertyName ?>;
    <?php else: ?>    
    /** @var <?= $makers->domainEntityMaker::getName($child) ?>[] $<?= $child->propertyName ?> */
    protected array $<?= $child->propertyName ?> = [];
    <?php endif; ?>
    <?php endforeach; ?>

    /************* Events Applier */

    <?php foreach ($entity->actions as $action): ?>
    /**
    * apply the event <?= $makers->domainEventMaker::getName($action) ?> on entity
    * related to action "<?= $action->name ?>" : <?= $action->description ?>  
    * role <?= $action->role ?>  
    * @see <?= $makers->domainEventMaker::getFullName($action) ?> 
    * @param <?= $makers->domainEventMaker::getName($action) ?> $event <?= $action->description ?>      
    */
    protected function apply<?= $makers->domainEventMaker::getName($action) ?>(<?= $makers->domainEventMaker::getName($action) ?> $event): self
    {
        // clone the existing instance, and apply changes
        //$instance = clone $this;
        
        <?php if($action->getProperties()): ?>
        //mapping parameters linked to an entity property
        <?php foreach ($action->getProperties() as $actionProperty): ?>
        <?php if($actionProperty->getNullableParameter()): ?>
        $this-><?= $actionProperty->property->name ?> = $event-><?= $actionProperty->getNullableParameter()->name ?> ? new <?= $makers->domainValueObjectMaker::getName($actionProperty->property->valueObject) ?>(
        <?php else: ?>
        $this-><?= $actionProperty->property->name ?> = new <?= $makers->domainValueObjectMaker::getName($actionProperty->property->valueObject) ?>(
        <?php endif; ?>
            <?php foreach ($actionProperty->inputs as $propertyInput): ?>
            <?php if ($propertyInput->input->hasLinkedProperty()): ?>
            <?php switch($propertyInput->input->getLinkedEntity()): case 'this': ?>
            <?= $propertyInput->input->valueObjectInput->name ?>: $this->get<?=ucfirst($propertyInput->input->getLinkedProperty()->name) ?>(),
            <?php break; ?>
            <?php case 'parent': ?>
            <?= $propertyInput->input->valueObjectInput->name ?>: $this->parent->get<?=ucfirst($propertyInput->input->getLinkedProperty()->name) ?>(),
            <?php break; ?>
            <?php endswitch; ?>
            <?php else: ?>
            <?php if ($propertyInput->parameter): ?>
            <?= $propertyInput->input->valueObjectInput->name ?>: $event-><?= $propertyInput->parameter->name ?>,
            <?php else: ?>
            <?= $propertyInput->input->valueObjectInput->name ?>: null,
            <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php if($actionProperty->getNullableParameter()): ?>
            ) : null;
            <?php else: ?>
            );
            <?php endif; ?>     
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($action->hasRelationParameter()): ?>
        //mapping parameters linked to an entity relation (external entity key)
        <?php foreach ($action->parameters as $parameter): ?>
        <?php if ($parameter->linkedToRelation()): ?>
        <?php if ($parameter->nullable): ?>
        $this-><?= $parameter->getTargetRelation()->name ?> = $event-><?= $parameter->name ?> ? new <?= $makers->domainValueObjectMaker::getName($parameter->getTargetRelation()->valueObject) ?>($event-><?= $parameter->name ?>) : null;
        <?php else: ?>
        $this-><?= $parameter->getTargetRelation()->name ?> = new <?= $makers->domainValueObjectMaker::getName($parameter->getTargetRelation()->valueObject) ?>($event-><?= $parameter->name ?>);
        <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>

        return $this;
    }    
    <?php endforeach; ?>

    /************* Children Entities Events Applier */

    <?php foreach ($entity->entities as $child): ?>
    <?php foreach ($child->actions as $action): ?>

    /**
    * apply the event <?= $makers->domainEventMaker::getName($action) ?> on this entity has parent
    * related to action "<?= $action->name ?>" : <?= $action->description ?>  of child entity <?= $child->name ?>
    * role <?= $action->role ?>  
    * @see <?= $makers->domainEventMaker::getFullName($action) ?> 
    * @param <?= $makers->domainEventMaker::getName($action) ?> $event <?= $action->description ?> 
    */
    protected function apply<?= $makers->domainEventMaker::getName($action) ?>(<?= $makers->domainEventMaker::getName($action) ?> $event): self
    {
        // this is a change action, clone the existing instance, and apply changes
        //$instance = clone $this;
        
        <?php if($child->isMany()): ?>
        <?php switch (true): case $action->isInsertAction(): ?>
        //create new child entity
        $child = new <?= $makers->domainEntityMaker::getName($child) ?>(id: new Id($event->entity_id), aggregate: $this->aggregate, parent: $this);
        //apply event on child entity
        $child = $child->apply($event);
        //add child to collection
        $this-><?= $child->propertyName ?>[$child->getId()->value] = $child;
        <?php break; case $action->isUpdateAction(): ?>
        //get child entity from collection
        $child = $this->get<?= ucfirst($child->propertyNameSingular) ?>(new Id($event->entity_id));//apply event on child entity
        //apply event on child entity
        $child = $child->apply($event);
        <?php break; case $action->isDeleteAction(): ?>
        //get child entity from collection
        $child = $this->get<?= ucfirst($child->propertyNameSingular) ?>(new Id($event->entity_id));
        //apply event on child entity
        $child = $child->apply($event);
        //remove child from collection
        unset($this-><?= $child->propertyName ?>[$child->getId()->value]); 
        <?php break; endswitch; ?>
        <?php else: ?>
        <?php switch (true): case $action->isInsertAction(): ?>
        //create new child entity
        $child = (new <?= $makers->domainEntityMaker::getName($child) ?>(id: new Id($event->entity_id), aggregate: $this->aggregate, parent: $this));
        //apply event on child entity
        $child = $child->apply($event);
        //set child in parent entity
        $this-><?= $child->propertyName ?> = $child;  
        <?php break; case $action->isUpdateAction(): ?>
        //get child entity
        $child = $this-><?= $child->propertyName ?>;
        //apply event on child entity
        $child = $child->apply($event);
        <?php break; case $action->isDeleteAction(): ?>
        //get child entity
        $child = $this-><?= $child->propertyName ?>;
        //apply event on child entity
        $child = $child->apply($event);
        //unset child in parent entity (this)
        $this-><?= $child->propertyName ?> = null;
        <?php break; endswitch; ?>
        <?php endif; ?>

        return $this;
    }
    <?php endforeach; ?>
    <?php endforeach; ?>

    <?php if ($entity->isRoot()): ?>
    /************* This Entity and child entities Action to Event function */

    <?php foreach ($entity->getAllActions() as $action): ?>
    /**
    * <?= $action->description ?> 
    * Action : "<?= $action->name ?>"
    * Create the event : <?= $makers->domainEventMaker->getName($action) ?> 
    * @see <?= $makers->domainEventMaker->getFullName($action) ?> 
    * @param string $entity_id entity id
    <?php foreach ($action->parameters as $parameter): ?>
    * @param <?= $parameter->nullable ? 'null|' : '' ?><?= $parameter->type ?> $<?= $parameter->name ?> <?= $parameter->description ?> 
    <?php endforeach; ?>
    */    
    public function <?= lcfirst($action->name) ?>(
        string $entity_id,
        <?php foreach ($action->parameters as $parameter): ?>
        <?= $parameter->nullable ? '?' : '' ?><?= $parameter->type ?> $<?= $parameter->name ?><?= $parameter->nullable ? ' = null' : '' ?>,
        <?php endforeach; ?>
    ): array {
        $event = new <?= $makers->domainEventMaker->getName($action) ?>( 
            id: $this->aggregate->getId(),//aggregate Id,
            entity_id: $entity_id,//entity Id
            <?php foreach ($action->parameters as $parameter): ?>
            <?= $parameter->name ?>: $<?= $parameter->name ?>,
            <?php endforeach; ?>
        );
        return [
            $this->aggregate->apply($event),
            [$event],
        ];
    }
    <?php endforeach; ?>
    <?php endif; ?>

    /************* Functionnal methods */

    /**
    * Set entity data from infra converter, like from a database mapper
    <?php foreach ($entity->properties as $property): ?>
    <?php if ($property->isId()) continue; ?>
    * @param <?= $property->nullable ? 'null|' : '' ?><?= $makers->domainValueObjectMaker->getName($property->valueObject) ?> $<?= $property->name ?> <?= $property->description ?> .
    <?php endforeach; ?>
    <?php foreach ($entity->relations as $relation): ?>
    * @param <?= $relation->nullable ? 'null|' : '' ?><?= $makers->domainValueObjectMaker->getName($relation->valueObject) ?> $<?= $relation->name ?> <?= $relation->description ?> .
    <?php endforeach; ?>
    */   
    public function set(
        <?php foreach ($entity->properties as $property): ?>
        <?php if ($property->isId()) continue; ?>
        <?= $property->nullable ? '?' : '' ?><?= $makers->domainValueObjectMaker->getName($property->valueObject) ?> $<?= $property->name ?>,
        <?php endforeach; ?>
        <?php foreach ($entity->relations as $relation): ?>
        <?= $relation->nullable ? '?' : '' ?><?= $makers->domainValueObjectMaker->getName($relation->valueObject) ?> $<?= $relation->name ?>,
        <?php endforeach; ?>        
    ): self 
    {
        <?php foreach ($entity->properties as $property): ?>
        <?php if ($property->isId()) continue; ?>
        $this-><?= $property->name ?> = $<?= $property->name ?>;
        <?php endforeach; ?>
        <?php foreach ($entity->relations as $relation): ?>
        $this-><?= $relation->name ?> = $<?= $relation->name ?>;
        <?php endforeach; ?>

        return $this;
    }

    /**
    * check if the entity can be used / modify
    * @return bool
    */
    abstract public function isUsabled(): bool;

    <?php if ($entity->getStateProperty()): ?>
    //Is states getters

    <?php foreach ($entity->getStateProperty()->valueObject->values as $state): ?>
    /**
    * check if the entity is in the "<?= $state ?>" state
    * @return bool
    */
    public function is<?= ucfirst($state) ?>(): bool
    {
        return $this-><?= lcfirst($entity->getStateProperty()->name) ?> == <?= $entity->getStateProperty()->valueObject->name ?>::<?= strtoupper($state) ?>();
    }
    <?php endforeach; ?>
    <?php endif; ?>

    /************* Voter */

    <?php foreach ($entity->actions as $action): ?>
    <?php if(!$action->isInsertAction()): ?>                
    /**
    * check if the action "<?= $action->name ?>" can be applied on entity
    * this check is done before appling any the action
    * can be used to list the allowed action on an instance of the <?= $entity->name ?> entity 
    * @return bool
    */
    abstract public function can<?= ucfirst($action->name) ?>(): bool;
    <?php endif; ?>
    <?php endforeach; ?>

    /************* Entity Properties Getter */

    <?php foreach ($entity->properties as $property): ?>
    <?php if(!$property->isId()): ?>
    /**
    * Get the <?= $entity->name ?> <?= $property->name ?> property
    * <?= $property->description ?> 
    */
    public function get<?= ucfirst($property->name) ?>(): <?= $property->nullable ? '?' : '' ?><?= $makers->domainValueObjectMaker->getName($property->valueObject) ?>
    {
        return $this-><?= $property->name ?>;
    }
    <?php endif; ?>
    <?php endforeach; ?>

    /************* Entity Relations Getter */

    <?php foreach ($entity->relations as $relation): ?>
    /**
    * Get the <?= $entity->name ?> <?= $relation->name ?> property/relation
    * <?= $relation->description ?> 
    * @return Id
    */
    public function get<?= ucfirst($relation->name) ?>(): <?= $relation->nullable ? '?' : '' ?><?= $makers->domainValueObjectMaker->getName($relation->valueObject) ?>
    {
        return $this-><?= $relation->name ?>;
    }
    <?php endforeach; ?>
    

    /************* Entity Child Entities Getter */

    /**
     * get sub entities of this entity
     * @return Entity[]
     */
    public function getChildEntities(): array{
        $children = [];
        <?php foreach ($entity->entities as $child): ?>
        <?php if($child->isOne()): ?>
        if($this-><?= $child->propertyName ?>){
            $children[] = $this-><?= $child->propertyName ?>;
        }
        <?php else: ?>    
        foreach($this-><?= $child->propertyName ?> as $childEntity){
            $children[] = $childEntity;
        }
        <?php endif; ?>
        <?php endforeach; ?>
        return $children;
    }

    <?php foreach ($entity->entities as $child): ?>
    <?php switch(true): case $child->isOne(): ?>
    /**
    * Get the <?= $child->name ?> <?= $child->name ?> child entity
    * <?= $child->description ?> 
    */
    public function get<?= ucfirst($child->name) ?>(): <?= $child->nullable ? '?' : '' ?><?= $makers->domainEntityMaker->getName($child) ?>
    {
        return $this-><?= $child->propertyName ?>;
    }
    <?php break; ?>
    <?php case $child->isMany(): ?>    
    /**
     * get all <?= $child->propertyName ?><?= "\n" ?>
     * @return <?= $makers->domainEntityMaker->getName($child) ?>[]
     */
    public function get<?= ucfirst($child->propertyName) ?>(): array
    {
        return $this-><?= $child->propertyName ?>;
    }
    /**
     * get an <?= $child->name ?> by it's id
     * @return <?= $makers->domainEntityMaker->getName($child) ?>
     */
    public function get<?= ucfirst($child->propertyNameSingular) ?>(Id $id): <?= $makers->domainEntityMaker->getName($child) ?>
    {
        return $this-><?= $child->propertyName ?>[$id->value];
    }
    <?php break; ?>
    <?php endswitch; ?>
    <?php endforeach; ?>
}