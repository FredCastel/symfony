<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================
 */

namespace Cluster\Domain\Event\Party;

use Core\Domain\Event\AbstractEvent;

/**
 * Event of the Party aggegate
 * linked to Disable action of Party entity
 * Disable : Disable party 
 * @internal GENERATED class NEVER CHANGE IT
 */
readonly final class PartyDisabledEvent extends AbstractEvent{
    /**
     * Create a new event PartyDisabled 
     * linked to action Disable 
     * of entity Party 
     *
     * @param string $id the aggregate id
     * @param string $entity_id the entity id
          */
    public function __construct(
        string $id,
        string $entity_id,
            ) {
    parent::__construct($id,$entity_id);
    }
}