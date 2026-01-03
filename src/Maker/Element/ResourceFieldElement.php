<?php

namespace Maker\Element;

class ResourceFieldElement extends AbstractElement
{
    /*
    "key": "e7d6f4cb-3afb-434b-a768-d9d3edeaac57",
    "name": "name",
    "description": "bank name Value",
    "enabled": true,
    "type": "string",
    "length": 3,
    "nullable": false,
    "target_property_ref": "a9d1aaa6-0aa4-466f-96b5-e22545f9d6c0",
    "target_property_input_ref": "3f281f49-4888-4dd2-9e12-875f46954f6c"  
    */
    public readonly string $type;
    public readonly bool $nullable;
    public readonly ?string $fieldType;
    public readonly ?int $length;
    protected string $target_property_ref;
    protected string $target_property_input_ref;
    protected static bool $lowerCaseName = true;

    public function __construct(
        public ResourceElement $resource,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->type = $data->type;
        $this->nullable = property_exists(object_or_class: $data, property: 'nullable') ? $data->nullable : false;
        $this->length = property_exists(object_or_class: $data, property: 'length') ? $data->length : null;

        $this->target_property_ref = $data->target_property_ref;
        $this->target_property_input_ref = $data->target_property_input_ref;

        $this->resource->addField($this);
    }

    public function getTargetProperty(): EntityPropertyElement
    {
        return self::get($this->target_property_ref);
    }

    public function getTargetPropertyInput(): EntityPropertyInputElement
    {
        return self::get($this->target_property_input_ref);
    }

    public function convertToPhp():?string
    {
        switch ($this->type) {
            case '\\DateTimeImmutable':
                return 'new \\DateTimeImmutable';    
            default:
                return null;
        }
    }
}