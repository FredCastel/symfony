<?php

namespace Maker\Element;

class ContextElement extends AbstractElement
{

    /**
     * Summary of aggregates
     * @var AggregateElement[]
     */
    public array $aggregates = [];
    /**
     * Summary of resources
     * @var ResourceElement[]
     */
    public array $resources = [];

    public function __construct(
        public readonly NamespaceElement $namespace,
        \stdClass $data
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;

        //add aggregates
        if (property_exists(object_or_class: $data, property: 'aggregates')) {
            foreach ($data->aggregates as $aggregate_data) {
                new AggregateElement(context: $this, data: $aggregate_data);
            }
        }
        //add resources
        if (property_exists(object_or_class: $data, property: 'resources')) {
            foreach ($data->resources as $resource_data) {
                new ResourceElement(context: $this, data: $resource_data);
            }
        }

        $this->namespace->addContext($this);
    }

    //aggregates
    public function addAggregate(AggregateElement $aggregate): self
    {
        $this->aggregates[$aggregate->key] = $aggregate;
        return $this;
    }
    public function getAggregate(string $key): AggregateElement
    {
        return $this->aggregates[$key];
    }

    //resources
    public function addResource(ResourceElement $resource): self
    {
        $this->resources[$resource->key] = $resource;
        return $this;
    }
    public function getResource(string $key): ResourceElement
    {
        return $this->resources[$key];
    }
}