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
 * linked to SetInitialBalance action of Account entity
 * SetInitialBalance : Set initial account balance when account is in draft status 
 * @internal GENERATED class NEVER CHANGE IT
 */
readonly final class AccountInitialBalanceSetEvent extends AbstractEvent{
    /**
     * Create a new event AccountInitialBalanceSet 
     * linked to action SetInitialBalance 
     * of entity Account 
     *
     * @param string $id the aggregate id
     * @param string $entity_id the entity id
          * @param float $balance set account initial balance 
          */
    public function __construct(
        string $id,
        string $entity_id,
                public float $balance,
            ) {
    parent::__construct($id,$entity_id);
    }
}