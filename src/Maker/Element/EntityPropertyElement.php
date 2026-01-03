<?php

namespace Maker\Element;

class EntityPropertyElement extends AbstractElement
{
    public readonly bool $nullable;
    public readonly ValueObjectElement $valueObject;
    protected static bool $lowerCaseName = true;
    /**
     * Summary of inputs
     * @var EntityPropertyInputElement[]
     */
    public $inputs = [];

    public function __construct(
        public EntityElement $entity,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);   

        if(!$this->enabled) return;

        $this->nullable = property_exists(object_or_class: $data, property: 'nullable') ? $data->nullable : false;

        $this->valueObject = self::get($data->value_object_ref);

        //add inputs
        if (property_exists(object_or_class: $data, property: 'inputs')) {
            foreach ($data->inputs as $input_data) {
                new EntityPropertyInputElement(property: $this, data: $input_data);
            }
        }else{
            throw new \InvalidArgumentException('Entity property '.$this->name.' must have at least one input defined.');
        }

        $this->entity->addProperty($this);
    }

    // public function valueObject(): ValueObjectElement
    // {
    //     return self::get($this->value_object_ref);
    // }

    public function isId(): bool
    {
        return $this->name === "id";
    }

    public function isState(): bool
    {
        return $this->valueObject->isState();
    }

    public function isCategory(): bool
    {
        return $this->valueObject->isCategory();
    }

    public function addInput(EntityPropertyInputElement $input): self
    {
        $this->inputs[$input->key] = $input;
        return $this;
    }

    public function getParameter(string $key): EntityPropertyInputElement
    {
        return $this->inputs[$key];
    }
}