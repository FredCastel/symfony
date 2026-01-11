<?php

namespace Core\Domain\Aggregate;

use Core\Domain\Aggregate\Entity;
use Core\Domain\ValueObject\ValueObject;

class EntityValidator
{
    public function validate(Entity $entity): self
    {
        $reflect = new \ReflectionClass($entity);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_PROTECTED);

        $propertyValidator = new PropertyValidator();
        foreach ($props as $prop) {
            if ($prop->getType()->getName() === 'array') {
                $array = $prop->getValue($entity);
                foreach ($array as $item) {
                    if (in_array(ValueObject::class, class_parents($prop->getType()->getName()))) {
                        $propertyValidator->validate($entity, $item);
                    }
                }
            } elseif (in_array(ValueObject::class, class_parents($prop->getType()->getName()))) {
                $propertyValidator->validate($entity, $prop->getValue($entity));
            }
        }

        //children
        foreach ($entity->getChildEntities() as $child) {
            $this->validate($child);
        }

        $entity->validate();

        return $this;
    }
}
