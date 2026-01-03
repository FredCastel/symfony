<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Domain\Repository\Party;

use Cluster\Domain\Aggregate\Party\Entity\Party;
use Core\Domain\Aggregate\Entity;
use Core\Domain\Repository\EntityRepository;

interface PartyEntityRepository extends EntityRepository
{
    /**
     * @return Party
     */
    public function get(string $id): Entity;
}
