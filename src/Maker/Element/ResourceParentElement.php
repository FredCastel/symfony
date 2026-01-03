<?php

namespace Maker\Element;

class ResourceParentElement extends AbstractElement
{
    /*
    {
    "key": "b9c86fb3-f385-484f-9f49-771964cdd2fc",
    "name": "account",
    "description": "An account, can be a cash or bank account key ",
    "enabled": true,
    "target_entity_ref": "e51b39c7-1309-4bcb-b233-e8ce83eef71b",
    "target_resource_ref": ""
    }  
    */
    public readonly string $target_entity_ref;
    public readonly string $target_resource_ref;
    protected static bool $lowerCaseName = true;

    public function __construct(
        public ResourceElement $resource,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->target_resource_ref = $data->target_resource_ref;
        $this->target_entity_ref = $data->target_entity_ref;

        $this->resource->addParent($this);
    }

    
    public function getTargetResource(): ResourceElement
    {
        return self::get($this->target_resource_ref);
    }

    public function getTargetEntity(): EntityElement
    {
        return self::get($this->target_entity_ref);
    }
}