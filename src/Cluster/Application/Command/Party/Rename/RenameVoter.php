<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Cluster\Application\Command\Party\Rename;

use Cluster\Application\Command\Party\_Tools\Getter\PartyGetterTrait;
use Cluster\Domain\Aggregate\Party\Entity\Party;
use Cluster\Domain\Repository\Party\PartyEntityRepository;
use Core\Application\Command\CommandIdVoter;
use Core\Application\Command\CommandVoterException;
use Core\Application\Message\InformationMessage;
use Core\Application\Response\Notification;

final class RenameVoter extends CommandIdVoter
{
    use PartyGetterTrait;

    public function __construct(
        private PartyEntityRepository $partyRepository,
    ) {
    }

    public function listenTo(): string
    {
        return RenameRequest::class;
    }

    protected function internalVoter($id): void
    {
        /**
         * @var Party
         */
        $entity = $this->partyRepository->get($id);

        if (!$entity->canRename()) {
            $notif = new Notification();
            $notif->addMessage(new InformationMessage('Rename', "Command can't be applied"));

            throw new CommandVoterException($notif);
        }
    }
}
