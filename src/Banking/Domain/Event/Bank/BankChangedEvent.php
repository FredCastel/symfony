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
 * linked to Change action of Bank entity
 * Change : Change bank simple properties.
 *
 * @internal GENERATED class NEVER CHANGE IT
 */
final readonly class BankChangedEvent extends AbstractEvent
{
    /**
     * Create a new event BankChanged
     * linked to action Change
     * of entity Bank.
     *
     * @param string      $id        the aggregate id
     * @param string      $entity_id the entity id
     * @param string      $name      change bank name
     * @param string|null $url       change bank url
     * @param string|null $bic       change bank bic code
     */
    public function __construct(
        string $id,
        string $entity_id,
        public string $name,
        public ?string $url,
        public ?string $bic,
    ) {
        parent::__construct($id, $entity_id);
    }
}
