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
 * linked to Rename action of Bank entity
 * Rename : Rename a bank.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class BankRenamedEvent extends AbstractEvent
{
    /**
     * Create a new event BankRenamed
     * linked to action Rename
     * of entity Bank.
     *
     * @param string $id        the aggregate id
     * @param string $entity_id the entity id
     * @param string $name      new Name
     */
    public function __construct(
        string $id,
        string $entity_id,
        public string $name,
    ) {
        parent::__construct($id, $entity_id);
    }
}
