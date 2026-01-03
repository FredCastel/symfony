<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\RemoveAccountOperation;

use Banking\Application\Command\Account\_Tools\Getter\OperationGetterTrait;
use Banking\Domain\Aggregate\Account\Entity\Operation;
use Banking\Domain\Repository\Account\OperationEntityRepository;
use Core\Application\Command\CommandIdVoter;
use Core\Application\Command\CommandVoterException;
use Core\Application\Message\InformationMessage;
use Core\Application\Response\Notification;

final class RemoveAccountOperationVoter extends CommandIdVoter
{
    use OperationGetterTrait;

    public function __construct(
        private OperationEntityRepository $operationRepository,
    ) {
    }

    public function listenTo(): string
    {
        return RemoveAccountOperationRequest::class;
    }

    protected function internalVoter($id): void
    {
        /**
         * @var Operation
         */
        $entity = $this->operationRepository->get($id);

        if (!$entity->canRemoveOperation()) {
            $notif = new Notification();
            $notif->addMessage(new InformationMessage('RemoveAccountOperation', "Command can't be applied"));

            throw new CommandVoterException($notif);
        }
    }
}
