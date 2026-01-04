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
 * linked to Open action of Account entity
 * Open : Change account state to opened.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class AccountOpenedEvent extends AbstractEvent
{
    /**
     * Create a new event AccountOpened
     * linked to action Open
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
