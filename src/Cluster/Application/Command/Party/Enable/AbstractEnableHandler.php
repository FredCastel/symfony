<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\Enable;

use Cluster\Application\Command\Party\_Tools\Getter\PartyAggregateGetterTrait;
use Cluster\Application\Command\Party\_Tools\Getter\PartyGetterTrait;
use Cluster\Domain\Aggregate\Party\PartyAggregate;
use Cluster\Domain\Repository\Party\PartyAggregateRepository;
use Cluster\Domain\Repository\Party\PartyEntityRepository;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Domain\Aggregate\AggregateValidator;

abstract class AbstractEnableHandler implements CommandHandler
{
    use PartyAggregateGetterTrait;
    use PartyGetterTrait;

    public function __construct(
        protected PartyAggregateRepository $partyAggregateRepository,
        protected PartyEntityRepository $partyEntityRepository,
    ) {
    }

    public function listenTo(): string
    {
        return EnableRequest::class;
    }

    /**
     * @param EnableRequest $command
     */
    public function execute(CommandRequest $command): CommandResponse
    {
        $aggregate = $this->requirePartyAggregate($command->id);
        // $entity = $this->requirePartyEntity($command->id);

        $this->check(
            $aggregate,
            $command,
        );

        [$aggregate, $events] = $this->save(
            $aggregate,
            $command,
        );

        $validator = new AggregateValidator();
        $validator->validate($aggregate);

        $this->partyAggregateRepository->save($aggregate, $events);

        return CommandResponse::withEvents($events);
    }

    abstract protected function check(
        PartyAggregate $aggregate,
        EnableRequest $command,
    ): void;

    abstract protected function save(
        PartyAggregate $aggregate,
        EnableRequest $command,
    ): array;
}
