<?php

namespace Maker\Element;

class EntityRelationElement extends AbstractElement
{
    public readonly ValueObjectElement $valueObject;
    public readonly bool $nullable;
    private readonly string $target_entity_ref;
    protected static bool $lowerCaseName = true;

    public function __construct(
        public readonly EntityElement $entity,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->nullable = property_exists(object_or_class: $data, property: 'nullable') ? $data->nullable : false;
        $this->target_entity_ref = $data->target_entity_ref;

        $this->valueObject = ValueObjectElement::getByName('Id');

        $this->entity->addRelation($this);
    }

    public function getTargetEntity(): EntityElement
    {
        return self::get($this->target_entity_ref);
    }
}