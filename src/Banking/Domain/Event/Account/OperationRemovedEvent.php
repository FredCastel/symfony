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
 * linked to RemoveOperation action of Operation entity
 * RemoveOperation : remove an operation in account 
 * @internal GENERATED class NEVER CHANGE IT
 */
readonly final class OperationRemovedEvent extends AbstractEvent{
    /**
     * Create a new event OperationRemoved 
     * linked to action RemoveOperation 
     * of entity Operation 
     *
     * @param string $id the aggregate id
     * @param string $entity_id the entity id
          */
    public function __construct(
        string $id,
        string $entity_id,
            ) {
    parent::__construct($id,$entity_id);
    }
}