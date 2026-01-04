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
 * linked to Remove action of Account entity
 * Remove : remove a closed account 
 * @internal GENERATED class NEVER CHANGE IT
 */
readonly final class AccountRemovedEvent extends AbstractEvent{
    /**
     * Create a new event AccountRemoved 
     * linked to action Remove 
     * of entity Account 
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