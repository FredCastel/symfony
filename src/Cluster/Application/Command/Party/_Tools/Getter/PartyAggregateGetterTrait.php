<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\_Tools\Getter;

use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Cluster\Domain\Repository\Party\PartyAggregateRepository;
use Core\Application\Command\CommandNotFoundEntityException;
use Core\Application\Command\CommandRequiredEntityException;

trait PartyAggregateGetterTrait
{
    protected PartyAggregateRepository $partyAggregateRepository;

    public function findPartyAggregate(?string $id): ?PartyAggregate
    {
        if (null == $id || '' == $id) {
            return null;
        }

        $aggregate = $this->partyAggregateRepository->get($id);

        if (null == $aggregate) {
            throw new CommandNotFoundEntityException('Party aggregate does not exists');
        }

        return $aggregate;
    }

    public function requirePartyAggregate(?string $id): PartyAggregate
    {
        if (null == $id || '' == $id) {
            throw new CommandRequiredEntityException('Party is required');
        }

        return $this->FindPartyAggregate($id);
    }
}
