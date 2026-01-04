<?php

namespace Maker\Element;

class CommandParameterElement extends AbstractElement
{
    public readonly string $type;
    public readonly bool $nullable;
    protected static bool $lowerCaseName = true;

    public readonly ?string $target_parameter_ref;

    public function __construct(
        public CommandElement $command,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);   

        if(!$this->enabled) return;
        
        $this->nullable = property_exists(object_or_class: $data, property: 'nullable') ? $data->nullable : false;
        $this->target_parameter_ref = property_exists(object_or_class: $data, property: 'target_parameter_ref') ? $data->target_parameter_ref : null;

        if (property_exists(object_or_class: $data, property: 'type')) {
            $this->type = $data->type;
        } else {
            //take it from action definition
            $this->type = $this->getTargetParameter()->type;
        }

        $this->command->addParameter($this);
    }

    public function linkedToParameter(): bool
    {
        return $this->target_parameter_ref !== null;
    }

    public function getTargetParameter(): ActionParameterElement
    {
        return self::get($this->target_parameter_ref);
    }

    public function isId(): bool
    {
        return $this->name === 'entity_id';
    }
}