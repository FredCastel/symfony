<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Aggregate\Bank;

use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\EntityRoot;

/**
 * @internal GENERATED class NEVER CHANGE IT
 */
final class BankAggregate extends Aggregate
{
    /** @var Bank */
    protected EntityRoot $root;

    protected function initRoot(): void
    {
        $this->root = new Bank(id: $this->id, aggregate: $this);
    }

    /**
     * @return Bank     */
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
