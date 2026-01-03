<?php
namespace Core\Domain\Aggregate;

class PropertyValidator
{
    public function validate(Entity $entity, $property): self
    {
        if (is_null($property))
            return $this;

        /** @var \Core\Domain\ValueObject\ValueObject */
        $valueObject = $property;
        if (method_exists($valueObject, 'check'))
            $valueObject->check();

        return $this;
    }
}