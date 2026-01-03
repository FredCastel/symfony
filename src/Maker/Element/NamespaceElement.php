<?php

namespace Maker\Element;

class NamespaceElement extends AbstractElement
{

    /**
     * Summary of contexts
     * @var ContextElement[]
     */
    public array $contexts = [];

    /**
     * Summary of valueObjects
     * @var ValueObjectElement[]
     */
    public array $valueObjects = [];

    public function __construct(
        public readonly ApplicationElement $application,
        \stdClass $data
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;

        if (property_exists(object_or_class: $data, property: 'value_objects')) {
            foreach ($data->value_objects as $value_object) {
                new ValueObjectElement(namespace: $this, data: $value_object);
            }
        }
        
        if (property_exists(object_or_class: $data, property: 'contexts')) {
            foreach ($data->contexts as $context_data) {
                new ContextElement(namespace: $this, data: $context_data);
            }
        }

        $this->application->addNamespace(namespace: $this);
    }

    public function addContext(ContextElement $context): self
    {
        $this->contexts[$context->key] = $context;
        return $this;
    }

    public function getContext(string $key): ContextElement
    {
        return $this->contexts[$key];
    }

    public function addValueObject(ValueObjectElement $valueObject): self
    {
        $this->valueObjects[$valueObject->key] = $valueObject;
        return $this;
    }

    public function getValueObject(string $key): ValueObjectElement
    {
        return $this->valueObjects[$key];
    }
}