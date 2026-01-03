<?php

namespace Maker\Element;

class ActionElement extends AbstractElement
{
    public readonly bool $root;
    public readonly string $eventName;
    public readonly string $role;
    public readonly ContextElement $context;
    public readonly AggregateElement $aggregate;

    /**
     * Summary of parameters
     * @var ActionParameterElement[]
     */
    public $parameters = [];

    public function __construct(
        public EntityElement $entity,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->root = false;
        $this->eventName = $data->event_name;
        $this->role = $data->role;
        
        $this->aggregate = $this->entity->aggregate;
        $this->context = $this->entity->aggregate->context;

        //add parameters
        if (property_exists(object_or_class: $data, property: 'parameters')) {
            foreach ($data->parameters as $parameter_data) {
                new ActionParameterElement(action: $this, data: $parameter_data);
            }
        }

        $this->entity->addAction($this);
    }

    public function isInsertAction(): bool
    {
        return $this->role === "insert";
    }
    public function isUpdateAction(): bool
    {
        return $this->role === "update";
    }
    public function isDeleteAction(): bool
    {
        return $this->role === "delete";
    }

    public function addParameter(ActionParameterElement $parameter): self
    {
        $this->parameters[$parameter->key] = $parameter;
        return $this;
    }

    public function getParameter(string $key): ActionParameterElement
    {
        return $this->parameters[$key];
    }

    /**
     * array of managed entity properties by name
     * @return ActionProperty[] 
     */
    public function getProperties(): array
    {
        /** @var ActionProperty[]  */
        $properties=[];

        //collect unique property inputs
        foreach ($this->parameters as $parameter) {
            if ($parameter->linkedToProperty()) {
                $properties[$parameter->getTargetProperty()->name] = new ActionProperty(
                    property: $parameter->getTargetProperty(),
                );              
            }
        }

        foreach ($properties as $actionProperty) {
            /** @var EntityPropertyInputElement $input */
            foreach ($actionProperty->property->inputs as $input) {
                $found = false;
                foreach ($this->parameters as $parameter) {                    
                    if ($parameter->linkedToProperty() && $parameter->getTargetPropertyInput()->key === $input->key) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $actionProperty->addInput(new ActionParameterPropertyInput(
                        input: $input,
                        parameter: null,
                    ));
                }else{
                    $actionProperty->addInput(new ActionParameterPropertyInput(
                        input: $input,
                        parameter: $parameter,
                    ));
                }
            }
        }

        return $properties;
    }

    /**
     * check if action has at least one parameter linked to an entity relation
     * @return bool
     */
    public function hasRelationParameter(): bool
    {   
        foreach ($this->parameters as $parameter) {
            if ($parameter->linkedToRelation()) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * check if action has at least one parameter without link
     * @return bool
    */
    public function hasFreeParameter(): bool
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter->withoutLink()) {
                return true;
            }
        }
        return false;
    }

    public function getCommand(): ?CommandElement
    {
        foreach ($this->aggregate->commands as $command) {
            if ($command->target_action_ref == $this->key) {
                return $command;
            }
        }
        return null;
    }
}