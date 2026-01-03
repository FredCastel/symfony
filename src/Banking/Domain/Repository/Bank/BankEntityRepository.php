<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Repository\Bank;

use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Repository\EntityRepository;

interface BankEntityRepository extends EntityRepository
{
    /**
     * @return Bank
     */
    public function get(string $id): Entity;
}
