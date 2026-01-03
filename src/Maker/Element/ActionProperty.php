<?php

namespace Maker\Element;

/**
 * An entity property with inputs existing as parameters in action
 */
class ActionProperty
{
    /**
     * Inputs existing as parameters in action
     * @var ActionParameterPropertyInput[]
     */ 
    public array $inputs;

    public function __construct(
        public readonly EntityPropertyElement $property,
    ) {
        $this->inputs = [];
    }

    public function addInput(ActionParameterPropertyInput $input): self
    {
        $this->inputs[$input->input->name] = $input;
        return $this;
    }

    public function getNullableParameter(): ?ActionParameterElement
    {
        if(!$this->property->nullable){
            return null;
        }
        foreach ($this->inputs as $input) {
            if ($input->parameter !== null && $input->parameter->nullable) {
                return $input->parameter;
            }
        }
        return null;
    }
}