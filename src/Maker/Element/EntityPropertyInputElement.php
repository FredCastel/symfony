<?php

namespace Maker\Element;

class EntityPropertyInputElement extends AbstractElement
{
    public readonly ValueObjectInputElement $valueObjectInput;
    public readonly ?string $linked_property_ref;
    protected static bool $lowerCaseName = true;

    public function __construct(
        public EntityPropertyElement $property,
        \stdClass $data,
    ) {
        parent::__construct(data: $data);   

        if(!$this->enabled) return;

        if (!property_exists(object_or_class: $data, property: 'valueObject_input_ref')) {
            throw new \InvalidArgumentException('Entity '.$this->property->name.' property input '.$this->name.' must have a valueObject_input_ref defined.');
        }
        $this->valueObjectInput = self::get($data->valueObject_input_ref);

        $this->linked_property_ref = property_exists(object_or_class: $data, property: 'linked_property_ref') ? $data->linked_property_ref : null;

        $this->property->addInput($this);
    }
    

    public function hasLinkedProperty(): bool
    {
        return null !== $this->linked_property_ref;
    }
    
    public function getLinkedProperty(): EntityPropertyElement
    {
        return self::get($this->linked_property_ref);
    }
    
    public function getLinkedEntity(): string
    {
        //search in entity a ref to the entity owner of the linked property

        //first in case of root entity it is obbligatory in own entity
        if($this->property->entity->isRoot()){
            return 'this';
        }

        //second search in own entity
        try {
            $this->property->entity->getProperty($this->linked_property_ref);            
            return 'this';
        } catch (\Throwable $th) {
            //ignore
        }

        //last search in parent
        try {
            $this->property->entity->parent->getProperty($this->linked_property_ref);            
            return 'parent';
        } catch (\Throwable $th) {
            //ignore
        }
        
        throw new \RuntimeException('Cannot find linked entity for property input '.$this->name.' of property '.$this->property->name.' in entity '.$this->property->entity->name.'.');
    }
}