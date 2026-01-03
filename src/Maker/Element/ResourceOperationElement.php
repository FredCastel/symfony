<?php

namespace Maker\Element;

class ResourceOperationElement extends AbstractElement
{
    /*
    "key": "5f360b08-33f9-4af4-9153-1027f8635076",
    "name": "Addaccountoperation",
    "enabled": true,
    "method": "POST",
    "target_command_ref": "7f5710c0-21f9-4192-90b9-2326994545c0" 
    */
    public readonly string $method;
    protected string $target_command_ref;
    protected static bool $lowerCaseName = true;

    public function __construct(
        public ResourceElement $resource,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->method = $data->method;

        $this->target_command_ref = $data->target_command_ref;

        $this->resource->addOperation($this);
    }

    public function getTargetCommand(): CommandElement
    {
        return self::get($this->target_command_ref);
    }
}