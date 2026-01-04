<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace Banking\Domain\Event\Account;

use Core\Domain\Event\AbstractEvent;

/**
 * Event of the Account aggegate
 * linked to AddOperation action of Operation entity
 * AddOperation : add a new operation in account 
 * @internal GENERATED class NEVER CHANGE IT
 */
readonly final class OperationAddedEvent extends AbstractEvent{
    /**
     * Create a new event OperationAdded 
     * linked to action AddOperation 
     * of entity Operation 
     *
     * @param string $id the aggregate id
     * @param string $entity_id the entity id
          * @param string $label set operation label 
          * @param float $amount  
          * @param string $valueDate  
          * @param string $operationDate  
          */
    public function __construct(
        string $id,
        string $entity_id,
                public string $label,
                public float $amount,
                public string $valueDate,
                public string $operationDate,
            ) {
    parent::__construct($id,$entity_id);
    }
}