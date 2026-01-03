<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Bank\DisableBank;

use Banking\Application\Command\Bank\_Tools\Getter\BankGetterTrait;
use Banking\Domain\Aggregate\Bank\Entity\Bank;
use Banking\Domain\Repository\Bank\BankEntityRepository;
use Core\Application\Command\CommandIdVoter;
use Core\Application\Command\CommandVoterException;
use Core\Application\Message\InformationMessage;
use Core\Application\Response\Notification;

final class DisableBankVoter extends CommandIdVoter
{
    use BankGetterTrait;

    public function __construct(
        private BankEntityRepository $bankRepository,
    ) {
    }

    public function listenTo(): string
    {
        return DisableBankRequest::class;
    }

    protected function internalVoter($id): void
    {
        /**
         * @var Bank
         */
        $entity = $this->bankRepository->get($id);

        if (!$entity->canDisable()) {
            $notif = new Notification();
            $notif->addMessage(new InformationMessage('DisableBank', "Command can't be applied"));

            throw new CommandVoterException($notif);
        }
    }
}
