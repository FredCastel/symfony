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
 * linked to Remove action of Bank entity
 * Remove : Delete a bank.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class BankRemovedEvent extends AbstractEvent
{
    /**
     * Create a new event BankRemoved
     * linked to action Remove
     * of entity Bank.
     *
     * @param string $id        the aggregate id
     * @param string $entity_id the entity id
     */
    public function __construct(
        public string $id,
        public string $entity_id,
    ) {
        parent::__construct($id, $entity_id);
    }
}
