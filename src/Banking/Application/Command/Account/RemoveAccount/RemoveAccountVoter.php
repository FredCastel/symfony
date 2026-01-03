<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\RemoveAccount;

use Banking\Application\Command\Account\_Tools\Getter\AccountGetterTrait;
use Banking\Domain\Aggregate\Account\Entity\Account;
use Banking\Domain\Repository\Account\AccountEntityRepository;
use Core\Application\Command\CommandIdVoter;
use Core\Application\Command\CommandVoterException;
use Core\Application\Message\InformationMessage;
use Core\Application\Response\Notification;

final class RemoveAccountVoter extends CommandIdVoter
{
    use AccountGetterTrait;

    public function __construct(
        private AccountEntityRepository $accountRepository,
    ) {
    }

    public function listenTo(): string
    {
        return RemoveAccountRequest::class;
    }

    protected function internalVoter($id): void
    {
        /**
         * @var Account
         */
        $entity = $this->accountRepository->get($id);

        if (!$entity->canRemove()) {
            $notif = new Notification();
            $notif->addMessage(new InformationMessage('RemoveAccount', "Command can't be applied"));

            throw new CommandVoterException($notif);
        }
    }
}
