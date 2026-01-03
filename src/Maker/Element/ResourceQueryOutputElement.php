<?php

namespace Maker\Element;

class ResourceQueryOutputElement extends AbstractElement
{
    /*
    "key": "c057f557-c73a-4842-bc66-5fbc1f4b2119",
    "name": "Label",
    "enabled": true,
    "type": "string",
    "nullable": false,
    "kind": "field",
    "target_field_ref": "0805b557-4fdf-43fe-b7dd-9f485c6d291b"
    */
    public readonly string $type;
    public readonly string $kind;
    public readonly bool $nullable;
    protected ?string $target_field_ref;
    protected ?string $target_association_ref;
    protected ?string $target_parent_ref;
    protected static bool $lowerCaseName = true;

    public function __construct(
        public ResourceQueryElement $query,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->type = $data->type;
        $this->kind = $data->kind;
        $this->nullable = $data->nullable;

        $this->target_field_ref = property_exists(object_or_class: $data, property: 'target_field_ref') ? $data->target_field_ref : null;
        $this->target_association_ref = property_exists(object_or_class: $data, property: 'target_association_ref') ? $data->target_association_ref : null;
        $this->target_parent_ref = property_exists(object_or_class: $data, property: 'target_parent_ref') ? $data->target_parent_ref : null;

        $this->query->addOutput($this);
    }

    public function isField(): bool
    {
        return $this->kind === 'field';
    }

    public function isAssociation(): bool
    {
        return $this->kind === 'association';
    }

    public function isParent(): bool
    {
        return $this->kind === 'parent';
    }

    public function getTargetField(): ?EntityPropertyElement
    {
        if ($this->isField()) {
            return self::get($this->target_field_ref);
        }
        return null;
    }
    public function getTargetAssociation(): ?ResourceAssociationElement
    {
        if ($this->isAssociation()) {
            return self::get($this->target_association_ref);
        }
        return null;
    }
    public function getTargetParent(): ?ResourceParentElement
    {
        if ($this->isParent()) {
            return self::get($this->target_parent_ref);
        }
        return null;
    }
    public function getTargetResource(): ?ResourceElement
    {
        if ($this->isAssociation()) {
            return self::get($this->getTargetAssociation()->target_resource_ref);
        }elseif ($this->isParent()) {
            return self::get($this->getTargetParent()->target_resource_ref);
        }    
        return null;    
    }
        
}