<?php

namespace Maker\Element;

class EntityChildElement extends EntityElement
{
    public readonly string $propertyName;
    public readonly ?string $propertyNameSingular;
    private readonly string $cardinality;

    public function __construct(
        public readonly EntityElement $parent,
        \stdClass $data,
    ) {
        parent::__construct(aggregate:$parent->aggregate, data: $data);

        if(!$this->enabled) return;
        
        $this->propertyName = lcfirst($data->property_name);
        $this->propertyNameSingular = property_exists(object_or_class: $data, property: 'property_name_singular') ? $data->property_name_singular : null;
        $this->cardinality = $data->cardinality;

        $this->parent->addEntity($this);
    }

    public function isRoot(): bool
    {
        return false;
    }

    public function isChild(): bool
    {
        return true;
    }

    public function isMany(): bool
    {
        return $this->cardinality === 'many';
    }

    public function isOne(): bool
    {
        return $this->cardinality === 'one';
    }
}