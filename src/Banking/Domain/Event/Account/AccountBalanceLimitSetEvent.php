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
 * linked to SetBalanceLimits action of Account entity
 * SetBalanceLimits : Set min and max balance amount.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class AccountBalanceLimitSetEvent extends AbstractEvent
{
    /**
     * Create a new event AccountBalanceLimitSet
     * linked to action SetBalanceLimits
     * of entity Account.
     *
     * @param string $id        the aggregate id
     * @param string $entity_id the entity id
     * @param float  $minimum   set account min balance allowed
     * @param float  $maximum   set account max balance allowed
     */
    public function __construct(
        public string $id,
        public string $entity_id,
        public float $minimum,
        public float $maximum,
    ) {
        parent::__construct($id, $entity_id);
    }
}
