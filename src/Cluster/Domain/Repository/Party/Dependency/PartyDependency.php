<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Domain\Repository\Party\Dependency;

use Cluster\Domain\Aggregate\Party\Entity\Party;
use Core\Domain\Repository\Dependency;

interface PartyDependency extends Dependency
{
    public function usedParty(Party $model): bool;
}
