<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Aggregate\Account;

use Banking\Domain\Aggregate\Account\Entity\Account;
use Core\Domain\Aggregate\Aggregate;
use Core\Domain\Aggregate\EntityRoot;

/**
 * @internal GENERATED class NEVER CHANGE IT
 */
final class AccountAggregate extends Aggregate
{
    /** @var Account */
    protected EntityRoot $root;

    protected function initRoot(): void
    {
        $this->root = new Account(id: $this->id, aggregate: $this);
    }

    /**
     * @return Account     */
    public function getRoot(): EntityRoot
    {
        return $this->root;
    }
}
