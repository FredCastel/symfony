<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\RegisterNatural;

use Cluster\Application\Command\Party\_Tools\Getter\PartyAggregateGetterTrait;
use Cluster\Application\Command\Party\_Tools\Getter\PartyGetterTrait;
use Cluster\Domain\Repository\Party\PartyAggregateRepository;
use Cluster\Domain\Repository\Party\PartyEntityRepository;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Domain\Aggregate\AggregateValidator;
use Core\Service\IdGenerator;

abstract class AbstractRegisterNaturalHandler implements CommandHandler
{
    use PartyAggregateGetterTrait;
    use PartyGetterTrait;

    public function __construct(
        protected IdGenerator $idGenerator,
        protected PartyAggregateRepository $partyAggregateRepository,
        protected PartyEntityRepository $partyEntityRepository,
    ) {
    }

    public function listenTo(): string
    {
        return RegisterNaturalRequest::class;
    }

    /**
     * @param RegisterNaturalRequest $command
     */
    public function execute(CommandRequest $command): CommandResponse
    {
        $this->check(
            $command,
        );

        [$aggregate, $events] = $this->save(
            $command,
        );

        $validator = new AggregateValidator();
        $validator->validate($aggregate);

        $this->partyAggregateRepository->save($aggregate, $events);

        return CommandResponse::withEvents($events);
    }

    abstract protected function check(
        RegisterNaturalRequest $command,
    ): void;

    abstract protected function save(
        RegisterNaturalRequest $command,
    ): array;
}
