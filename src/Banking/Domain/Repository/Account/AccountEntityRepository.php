<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Domain\Repository\Account;

use Banking\Domain\Aggregate\Account\Entity\Account;
use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Cluster\Domain\Aggregate\Party\Entity\Party;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Repository\EntityRepository;

interface AccountEntityRepository extends EntityRepository
{
    /**
     * @return Account
     */
    public function get(string $id): Entity;

    public function usedBank(Bank $model): bool;

    public function usedParty(Party $model): bool;
}
