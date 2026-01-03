<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Repository\Account\Dependency;

use Banking\Domain\Aggregate\Account\Entity\Operation;
use Core\Domain\Repository\Dependency;

interface OperationDependency extends Dependency
{
    public function usedOperation(Operation $model): bool;
}
