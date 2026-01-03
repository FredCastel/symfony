<?php

namespace Maker\Element;

class ResourceAssociationElement extends AbstractElement
{
    /*
    {
    "key": "8e8d5bfc-5b87-453c-8aaf-bc40107f6c01",
    "name": "bankid",
    "description": "the related bank id in case of bank account key ",
    "enabled": true,
    "nullable": true,
    "target_relation_ref": "608dd87e-9d1e-4f99-85ff-e7b05ec31552",
    "target_resource_ref": ""
    }  
    */
    public readonly bool $nullable;
    public readonly string $target_relation_ref;
    public readonly string $target_resource_ref;
    protected static bool $lowerCaseName = true;

    public function __construct(
        public ResourceElement $resource,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->nullable = property_exists(object_or_class: $data, property: 'nullable') ? $data->nullable : false;
        $this->target_resource_ref = $data->target_resource_ref;
        $this->target_relation_ref = $data->target_relation_ref;

        $this->resource->addAssociation($this);
    }

    
    public function getTargetResource(): ResourceElement
    {
        return self::get($this->target_resource_ref);
    }

    public function getTargetRelation(): EntityRelationElement
    {
        return self::get($this->target_relation_ref);
    }
}