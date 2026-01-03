<?php

namespace Maker\Element;

class ResourceQueryElement extends AbstractElement
{
    /*
    "key": "8761507c-f330-43f9-b00b-d1ddf5486fce",
    "name": "",
    "enabled": true,
    "method": "GET",
    "type": "collection",
    "root": true,
    "outputs": [ ... ],
    */
    public readonly string $method;
    public readonly string $type;
    public readonly bool $root;
    public readonly string $apiPath;
    protected string $target_command_ref;
    protected static bool $lowerCaseName = true;

    /**
     * Summary of outputs
     * @var ResourceQueryOutputElement[]
     */
    public array $outputs = [];

    public function __construct(
        public ResourceElement $resource,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->method = $data->method;
        $this->type = $data->type;
        $this->root = $data->root;
        $this->apiPath = $data->api_path;

        //add outputs
        if (property_exists(object_or_class: $data, property: 'outputs')) {
            foreach ($data->outputs as $output_data) {
                new ResourceQueryOutputElement(query: $this, data: $output_data);
            }
        }

        $this->resource->addQuery($this);
    }

    public function isRoot(): bool
    {
        return $this->root;
    }

    public function isItemQuery(): bool
    {
        return $this->type === 'item';
    }

    public function isCollectionQuery(): bool
    {
        return $this->type === 'collection';
    }

    //outputs
    public function addOutput(ResourceQueryOutputElement $output): self
    {
        $this->outputs[$output->key] = $output;
        return $this;
    }

    public function getOutput(string $key): ResourceQueryOutputElement
    {
        return $this->outputs[$key];
    }

    /**
     * Summary of addSubResource
     * @return ResourceElement[] 
     */
    public function getSubResources(): array
    {
        $subResources = [];
        foreach ($this->outputs as $output) {
            if (in_array($output->kind, ['association', 'parent'])) {
                $subResources[] = $output->getTargetResource();
            }
        }
        return $subResources;
    }
}