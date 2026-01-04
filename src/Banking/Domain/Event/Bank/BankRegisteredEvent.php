<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace Banking\Domain\Event\Bank;

use Core\Domain\Event\AbstractEvent;

/**
 * Event of the Bank aggegate
 * linked to Register action of Bank entity
 * Register : Create a new bank 
 * @internal GENERATED class NEVER CHANGE IT
 */
readonly final class BankRegisteredEvent extends AbstractEvent{
    /**
     * Create a new event BankRegistered 
     * linked to action Register 
     * of entity Bank 
     *
     * @param string $id the aggregate id
     * @param string $entity_id the entity id
          * @param string $name bank name 
          * @param string $state bank initial state 
          * @param string $country bank country 
          * @param null|string $url url of the bank 
          * @param null|string $bic bic code of the bank 
          * @param null|string $image logo of the bank 
          * @param null|string $validSince bank validity start date, can be null 
          * @param null|string $validUntil bank validity end date, can be null 
          */
    public function __construct(
        string $id,
        string $entity_id,
                public string $name,
                public string $state,
                public string $country,
                public ?string $url,
                public ?string $bic,
                public ?string $image,
                public ?string $validSince,
                public ?string $validUntil,
            ) {
    parent::__construct($id,$entity_id);
    }
}