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
 * linked to Rename action of Party entity
 * Rename : Change name.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class PartyRenamedEvent extends AbstractEvent
{
    /**
     * Create a new event PartyRenamed
     * linked to action Rename
     * of entity Party.
     *
     * @param string $id        the aggregate id
     * @param string $entity_id the entity id
     * @param string $name      Party Name
     */
    public function __construct(
        public string $id,
        public string $entity_id,
        public string $name,
    ) {
        parent::__construct($id, $entity_id);
    }
}
