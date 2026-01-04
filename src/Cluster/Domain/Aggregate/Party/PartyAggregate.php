<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Domain\Aggregate\Party;

use Cluster\Domain\Aggregate\Party\Entity\Party;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\EntityRoot;

/**
 * @internal GENERATED class NEVER CHANGE IT
 */
final class PartyAggregate extends Aggregate
{
    /** @var Party */
    protected EntityRoot $root;

    protected function initRoot(): void
    {
        $this->root = new Party(id: $this->id, aggregate: $this);
    }

    /**
     * @return Party     */
    public function getRoot(): EntityRoot
    {
        return $this->root;
    }

    /**
     * get all aggregate entities.
     *
     * used in get() method in entity repository
     *
     * @return Entity[] array of entities with id as table key
     */
    public function getEntities(): array
    {
        return $this->root->getChildEntities();
    }
}
