<?php

namespace Maker\Element;

class ResourceElement extends AbstractElement
{
    /*
    "key": "8a0b2b9e-69bc-4a48-9de1-87dd40fc18b2",
    "name": "Bank",
    "enabled": true,
    "table_name": "banking_bank",
    "api_path": "banking-bank",
    "target_entity_ref": "27856928-0382-46c7-b87e-0db00b61734e",
    "fields": [
    ...
    ],
    "associations": [
    */

    public readonly string $target_entity_ref;
    public readonly string $tableName;
    public readonly string $apiPath;
    
    /**
     * Summary of associations
     * @var ResourceFieldElement[]
     */
    public array $fields = [];
    /**
     * Summary of associations
     * @var ResourceAssociationElement[]
     */
    public array $associations = [];
    /**
     * Summary of parents
     * @var ResourceParentElement[]
     */
    public array $parents = [];
    /**
     * Summary of operations
     * @var ResourceOperationElement[]
     */
    public array $operations = [];
    /**
     * Summary of queries
     * @var ResourceQueryElement[]
     */
    public array $queries = [];

    public function __construct(
        public readonly ContextElement $context,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);

        if(!$this->enabled) return;
        
        $this->target_entity_ref = $data->target_entity_ref;
        $this->tableName = $data->table_name;
        $this->apiPath = $data->api_path;

        // //add field Id
        // $idData = new \stdClass();
        // $idData->key = "id_$this->name";
        // $idData->name = "id";
        // $idData->type = "Uuid";
        // $idData->value_object_ref = "core>id";
        // new ResourceFieldElement(Resource: $this, data: $idData);
        
        //add fields
        if (property_exists(object_or_class: $data, property: 'fields')) {
            foreach ($data->fields as $field_data) {
                new ResourceFieldElement(resource: $this, data: $field_data);
            }
        }

        //add associations
        if (property_exists(object_or_class: $data, property: 'associations')) {
            foreach ($data->associations as $association_data) {
                new ResourceAssociationElement(resource: $this, data: $association_data);
            }
        }

        //add parents
        if (property_exists(object_or_class: $data, property: 'parents')) {
            foreach ($data->parents as $parent_data) {
                new ResourceParentElement(resource: $this, data: $parent_data);
            }
        }

        //add operations
        if (property_exists(object_or_class: $data, property: 'operations')) {
            foreach ($data->operations as $operation_data) {
                new ResourceOperationElement(resource: $this, data: $operation_data);
            }
        }

        //add queries
        if (property_exists(object_or_class: $data, property: 'queries')) {
            foreach ($data->queries as $query_data) {
                new ResourceQueryElement(resource: $this, data: $query_data);
            }
        }

        $this->context->addResource($this);
    }
    
    public function getTargetEntity(): EntityElement
    {
        return self::get($this->target_entity_ref);
    }

    //fields
    public function addField(ResourceFieldElement $field): self
    {
        $this->fields[$field->key] = $field;
        return $this;
    }

    public function getField(string $key): ResourceFieldElement
    {
        return $this->fields[$key];
    }

    //associations
    public function addAssociation(ResourceAssociationElement $association): self
    {
        $this->associations[$association->key] = $association;
        return $this;
    }

    public function getAssociation(string $key): ResourceAssociationElement
    {
        return $this->associations[$key];
    }

    //parents
    public function addParent(ResourceParentElement $parent): self
    {
        $this->parents[$parent->key] = $parent;
        return $this;
    }

    public function getParent(string $key): ResourceParentElement
    {
        return $this->parents[$key];
    }

    //operations
    public function addOperation(ResourceOperationElement $operation): self
    {
        $this->operations[$operation->key] = $operation;
        return $this;
    }

    public function getOperation(string $key): ResourceOperationElement
    {
        return $this->operations[$key];
    }

    //queries
    public function addQuery(ResourceQueryElement $query): self
    {
        $this->queries[$query->key] = $query;
        return $this;
    }

    public function getQuery(string $key): ResourceQueryElement
    {
        return $this->queries[$key];
    }

    /**
     * Summary of addSubResource
     * @return ResourceElement[] 
     */
    public function getSubResources(): array
    {
        $subResources = [];
        foreach ($this->associations as $association) {
            $subResources[] = $association->getTargetResource();
        }
        foreach ($this->parents as $parent) {
            $subResources[] = $parent->getTargetResource();
        }
        return $subResources;
    }
}