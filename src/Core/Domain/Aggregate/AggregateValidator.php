<?php

namespace Core\Domain\Aggregate;

use Core\Domain\ValueObject\ValueObject;

class AggregateValidator
{
    public function validate(Aggregate $aggregate): self
    {
        $entityValidator = new EntityValidator();
        
        //root
        $entityValidator->validate($aggregate->getRoot());

        return $this;
    }
}