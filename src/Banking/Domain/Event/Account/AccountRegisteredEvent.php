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
 * linked to Register action of Account entity
 * Register : Create a new account 
 * @internal GENERATED class NEVER CHANGE IT
 */
readonly final class AccountRegisteredEvent extends AbstractEvent{
    /**
     * Create a new event AccountRegistered 
     * linked to action Register 
     * of entity Account 
     *
     * @param string $id the aggregate id
     * @param string $entity_id the entity id
          * @param string $name account name 
          * @param string $state account initial state 
          * @param string $category account category 
          * @param string $currency account currency 
          * @param null|string $validSince account validity start date, can be null 
          * @param null|string $validUntil account validity end date, can be null 
          * @param null|string $bankId id of the related bank 
          * @param string $partyId relation to Party 
          */
    public function __construct(
        string $id,
        string $entity_id,
                public string $name,
                public string $state,
                public string $category,
                public string $currency,
                public ?string $validSince,
                public ?string $validUntil,
                public ?string $bankId,
                public string $partyId,
            ) {
    parent::__construct($id,$entity_id);
    }
}