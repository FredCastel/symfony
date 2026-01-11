<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Event\Bank;

use Core\Domain\Event\AbstractEvent;

/**
 * Event of the Bank aggegate
 * linked to Register action of Bank entity
 * Register : Create a new bank.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class BankRegisteredEvent extends AbstractEvent
{
    /**
     * Create a new event BankRegistered
     * linked to action Register
     * of entity Bank.
     *
     * @param string      $id        the aggregate id
     * @param string      $entity_id the entity id
     * @param string      $name      bank name
     * @param string      $state     bank initial state
     * @param string      $country   bank country
     * @param string|null $url       url of the bank
     * @param string|null $bic       bic code of the bank
     */
    public function __construct(
        string $id,
        string $entity_id,
        public string $name,
        public string $state,
        public string $country,
        public ?string $url,
        public ?string $bic,
    ) {
        parent::__construct($id, $entity_id);
    }
}
