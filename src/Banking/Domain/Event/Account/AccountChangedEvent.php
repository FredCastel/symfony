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
 * linked to Change action of Account entity
 * Change : Change account simple properties 
 * @internal GENERATED class NEVER CHANGE IT
 */
readonly final class AccountChangedEvent extends AbstractEvent{
    /**
     * Create a new event AccountChanged 
     * linked to action Change 
     * of entity Account 
     *
     * @param string $id the aggregate id
     * @param string $entity_id the entity id
          * @param string $name change account name 
          */
    public function __construct(
        string $id,
        string $entity_id,
                public string $name,
            ) {
    parent::__construct($id,$entity_id);
    }
}