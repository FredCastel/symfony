<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\Remove;

use Cluster\Application\Command\Party\_Tools\Getter\PartyGetterTrait;
use Cluster\Domain\Aggregate\Party\Entity\Party;
use Cluster\Domain\Repository\Party\PartyEntityRepository;
use Core\Application\Command\CommandIdVoter;
use Core\Application\Command\CommandVoterException;
use Core\Application\Message\InformationMessage;
use Core\Application\Response\Notification;

final class RemoveVoter extends CommandIdVoter
{
    use PartyGetterTrait;

    public function __construct(
        private PartyEntityRepository $partyRepository,
    ) {
    }

    public function listenTo(): string
    {
        return RemoveRequest::class;
    }

    protected function internalVoter($id): void
    {
        /**
         * @var Party
         */
        $entity = $this->partyRepository->get($id);

        if (!$entity->canRemove()) {
            $notif = new Notification();
            $notif->addMessage(new InformationMessage('Remove', "Command can't be applied"));

            throw new CommandVoterException($notif);
        }
    }
}
