<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\RegisterLegal;

use Cluster\Application\Command\Party\_Tools\Getter\PartyAggregateGetterTrait;
use Cluster\Application\Command\Party\_Tools\Getter\PartyGetterTrait;
use Cluster\Domain\Repository\Party\PartyAggregateRepository;
use Cluster\Domain\Repository\Party\PartyEntityRepository;
use Core\Application\Command\CommandHandler;
use Core\Application\Command\CommandRequest;
use Core\Application\Command\CommandResponse;
use Core\Domain\Aggregate\AggregateValidator;
use Core\Service\IdGenerator;

abstract class AbstractRegisterLegalHandler implements CommandHandler
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
        return RegisterLegalRequest::class;
    }

    /**
     * @param RegisterLegalRequest $command
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
        RegisterLegalRequest $command,
    ): void;

    abstract protected function save(
        RegisterLegalRequest $command,
    ): array;
}
