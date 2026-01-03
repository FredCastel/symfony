<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Repository\Account;

use Banking\Domain\Aggregate\Account\Entity\Operation;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Repository\EntityRepository;

interface OperationEntityRepository extends EntityRepository
{
    /**
     * @return Operation
     */
    public function get(string $id): Entity;
}
