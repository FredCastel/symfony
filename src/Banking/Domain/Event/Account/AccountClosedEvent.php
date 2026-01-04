<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Event\Account;

use Core\Domain\Event\AbstractEvent;

/**
 * Event of the Account aggegate
 * linked to Close action of Account entity
 * Close : Change account state to closed.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class AccountClosedEvent extends AbstractEvent
{
    /**
     * Create a new event AccountClosed
     * linked to action Close
     * of entity Account.
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
