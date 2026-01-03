<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Repository\Account\Dependency;

use Banking\Domain\Aggregate\Account\Entity\Account;
use Core\Domain\Repository\Dependency;

interface AccountDependency extends Dependency
{
    public function usedAccount(Account $model): bool;
}
