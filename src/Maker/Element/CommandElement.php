<?php

namespace Maker\Element;

class CommandElement extends AbstractElement
{
    public readonly string $target_aggregate_ref;
    public readonly string $target_action_ref;
    public readonly ActionElement $action;

    /**
     * Summary of parameters
     * @var CommandParameterElement[]
     */
    public array $parameters = [];

    public function __construct(
        public readonly AggregateElement $aggregate,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->target_action_ref = $data->target_action_ref;

        //add parameters Id
        $entity_id = new \stdClass();
        $entity_id->key = "entity_id_$this->name";
        $entity_id->name = "entity_id";
        $entity_id->type = "string";
        //$entity_id->target_parameter_ref = $this->target_action_ref . ".entity_id";
        new CommandParameterElement(command: $this, data: $entity_id);
   
        //add parameters
        if (property_exists(object_or_class: $data, property: 'parameters')) {
            foreach ($data->parameters as $parameter_data) {
                new CommandParameterElement(command: $this, data: $parameter_data);
            }
        }

        $this->aggregate->addCommand($this);
    }

    public function addParameter(CommandParameterElement $parameter): self
    {
        $this->parameters[$parameter->key] = $parameter;
        return $this;
    }

    public function getParameter(string $key): CommandParameterElement
    {
        return $this->parameters[$key];
    }

    public function getParameterForActionparameter(ActionParameterElement $actionParameter): ?CommandParameterElement
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter->linkedToParameter() && $parameter->getTargetParameter() == $actionParameter) {
                return $parameter;
            }
        }
        return null;
    }

    public function getTargetAggregate(): AggregateElement
    {
        return self::get($this->target_aggregate_ref);
    }

    public function getTargetAction(): ActionElement
    {
        return self::get($this->target_action_ref);
    }
    public function getTargetEntity(): EntityElement
    {
        return $this->getTargetAction()->entity;
    }
}