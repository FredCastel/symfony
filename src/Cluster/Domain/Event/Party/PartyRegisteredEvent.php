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
 * linked to Register action of Party entity
 * Register : Register a new Party.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class PartyRegisteredEvent extends AbstractEvent
{
    /**
     * Create a new event PartyRegistered
     * linked to action Register
     * of entity Party.
     *
     * @param string      $id        the aggregate id
     * @param string      $entity_id the entity id
     * @param string      $name      Party Name
     * @param string      $state     Party State
     * @param string      $category  Party Category
     * @param string|null $url       Party url
     */
    public function __construct(
        string $id,
        string $entity_id,
        public string $name,
        public string $state,
        public string $category,
        public ?string $url,
    ) {
        parent::__construct($id, $entity_id);
    }
}
