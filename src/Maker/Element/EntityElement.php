<?php

namespace Maker\Element;

abstract class EntityElement extends AbstractElement
{   
    /**
     * Summary of properties
     * @var EntityPropertyElement[]
     */
    public array $properties = [];

    /**
     * Summary of relations
     * @var EntityRelationElement[]
     */
    public array $relations = [];

    /**
     * Summary of entyties
     * @var EntityElement[]
     */
    public array $entities = [];

    /**
     * Summary of commands
     * @var ActionElement[]
     */
    public array $actions = [];
    public function __construct(        
        public readonly AggregateElement $aggregate,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        //add property Id
        $id = new \stdClass();
        $id->key = "id_$this->key";
        $id->name = "id";
        $id->value_object_ref = "core>id";
        $id->inputs = [
            (object)[
                'key' => "id_input_$this->key",
                'name' => 'Value',
                'valueObject_input_ref' => 'core>id>input',
            ],
        ];
        new EntityPropertyElement(entity: $this, data: $id);
        //add properties
        if (property_exists(object_or_class: $data, property: 'properties')) {
            foreach ($data->properties as $property_data) {
                new EntityPropertyElement(entity: $this, data: $property_data);
            }
        }

        //add relations
        if (property_exists(object_or_class: $data, property: 'relations')) {
            foreach ($data->relations as $relation_data) {
                new EntityRelationElement(entity: $this, data: $relation_data);
            }
        }

        //add entities
        if (property_exists(object_or_class: $data, property: 'entities')) {
            foreach ($data->entities as $entity_data) {
                new EntityChildElement(parent: $this, data: $entity_data);
            }
        }

        //add actions
        if (property_exists(object_or_class: $data, property: 'actions')) {
            foreach ($data->actions as $action_data) {
                new ActionElement(entity: $this, data: $action_data);
            }
        }
    }

    abstract public function isRoot(): bool;
    abstract public function isChild(): bool;


    public function addProperty(EntityPropertyElement $property): self
    {
        $this->properties[$property->key] = $property;
        return $this;
    }

    public function getProperty(string $key): EntityPropertyElement
    {
        return $this->properties[$key];
    }

    public function addRelation(EntityRelationElement $relation): self
    {
        $this->relations[$relation->key] = $relation;
        return $this;
    }

    public function getRelation(string $key): EntityRelationElement
    {
        return $this->relations[$key];
    }

    public function addEntity(EntityElement $entity): self
    {
        $this->entities[$entity->key] = $entity;
        return $this;
    }

    public function getEntity(string $key): EntityElement
    {
        return $this->entities[$key];
    }

    public function addAction(ActionElement $action): self
    {
        $this->actions[$action->key] = $action;
        return $this;
    }

    public function getAction(string $key): ActionElement
    {
        return $this->actions[$key];
    }

    public function getStateProperty(): ?EntityPropertyElement
    {
        foreach ($this->properties as $property) {
            if ($property->isState()) {
                return $property;
            }
        }
        return null;
    }

    public function getCategoryProperty(): ?EntityPropertyElement
    {
        foreach ($this->properties as $property) {
            if ($property->isCategory()) {
                return $property;
            }
        }
        return null;
    }
    
    /**
     * Returns all child entities recursively
     * @return EntityElement[]
     */
    public function getChildEntities(): array
    {
        /** @var EntityElement[] */
        $list = [];
        foreach ($this->entities as $entity) {
            $list = array_merge($list, [$entity], $entity->getChildEntities());
        }
        return $list;
    }

    /**
     * return all actions including child entities actions
     * @var ActionElement[]
     */
    public function getAllActions(): array
    {
        $actions = $this->actions;
        foreach ($this->entities as $childEntity) {
            $actions = array_merge($actions, $childEntity->getAllActions());
        }
        return $actions;
    }
}