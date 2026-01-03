<?php

namespace Maker\Element;

class ActionParameterElement extends AbstractElement
{
    public readonly string $type;
    public readonly bool $nullable;
    private readonly ?string $target_property_ref;
    private readonly ?string $target_property_input_ref;
    private readonly ?string $target_relation_ref;
    protected static bool $lowerCaseName = true;

    public function __construct(
        public ActionElement $action,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->nullable = property_exists(object_or_class: $data, property: 'nullable') ? $data->nullable : false;
        $this->type = $data->type;
        $this->target_property_ref = property_exists(object_or_class: $data, property: 'target_property_ref') ? $data->target_property_ref : null;
        $this->target_property_input_ref = property_exists(object_or_class: $data, property: 'target_property_input_ref') ? $data->target_property_input_ref : null;
        $this->target_relation_ref = property_exists(object_or_class: $data, property: 'target_relation_ref') ? $data->target_relation_ref : null;

        $this->action->addParameter($this);
    }

    public function withoutLink(): bool
    {
        return $this->target_property_ref === null && $this->target_relation_ref === null;
    }

    public function linkedToProperty(): bool
    {
        return $this->target_property_ref !== null;
    }

    public function linkedToRelation(): bool
    {
        return $this->target_relation_ref !== null;
    }

    public function getTargetProperty(): EntityPropertyElement
    {
        return self::get($this->target_property_ref);
    }

    public function getTargetPropertyInput(): EntityPropertyInputElement
    {
        return self::get($this->target_property_input_ref);
    }

    public function getTargetRelation(): EntityRelationElement
    {
        return self::get($this->target_relation_ref);
    }
}