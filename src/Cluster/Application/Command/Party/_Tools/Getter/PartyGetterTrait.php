<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\_Tools\Getter;

use Cluster\Domain\Aggregate\Party\Entity\Party;
use Cluster\Domain\Repository\Party\PartyEntityRepository;
use Core\Application\Command\CommandNotFoundEntityException;
use Core\Application\Command\CommandRequiredEntityException;

trait PartyGetterTrait
{
    protected PartyEntityRepository $partyEntityRepository;
    protected iterable $partyDependencies = [];

    public function findPartyEntity(?string $id): ?Party
    {
        if (null == $id || '' == $id) {
            return null;
        }

        $entity = $this->partyEntityRepository->get($id);

        if (null == $entity) {
            throw new CommandNotFoundEntityException('Party entity does not exists');
        }

        return $entity;
    }

    public function requirePartyEntity(?string $id): Party
    {
        if (null == $id || '' == $id) {
            throw new CommandRequiredEntityException('Party is required');
        }

        return $this->FindPartyEntity($id);
    }

    public function isPartyUsed(?Party $entity): bool
    {
        if (null == $entity) {
            return false;
        }

        foreach ($this->partyDependencies as $dependency) {
            if ($dependency->usedParty($entity)) {
                return true;
            }
        }

        return false;
    }
}
