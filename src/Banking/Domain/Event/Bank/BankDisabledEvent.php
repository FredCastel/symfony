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
 * linked to Disable action of Bank entity
 * Disable : Change bank status to disabled.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class BankDisabledEvent extends AbstractEvent
{
    /**
     * Create a new event BankDisabled
     * linked to action Disable
     * of entity Bank.
     *
     * @param string $id        the aggregate id
     * @param string $entity_id the entity id
     */
    public function __construct(
        string $id,
        string $entity_id,
    ) {
        parent::__construct($id, $entity_id);
    }
}
