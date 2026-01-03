<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Repository\Bank\Dependency;

use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Core\Domain\Repository\Dependency;

interface BankDependency extends Dependency
{
    public function usedBank(Bank $model): bool;
}
