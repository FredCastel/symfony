<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Domain\Event\Party;

use Core\Domain\Event\AbstractEvent;

/**
 * Event of the Party aggegate
 * linked to Enable action of Party entity
 * Enable : Enable party.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class PartyEnabledEvent extends AbstractEvent
{
    /**
     * Create a new event PartyEnabled
     * linked to action Enable
     * of entity Party.
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
