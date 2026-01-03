<?php
/**
 *===========================================
 *===== GENERATED class NEVER CHANGE IT  ====
 *===========================================.
 */

namespace Banking\Application\Command\Account\AddAccountOperation;

use Banking\Application\Command\Account\_Tools\Getter\OperationGetterTrait;
use Banking\Domain\Aggregate\Account\Entity\Operation;
use Banking\Domain\Repository\Account\OperationEntityRepository;
use Core\Application\Command\CommandIdVoter;

final class AddAccountOperationVoter extends CommandIdVoter
{
    use OperationGetterTrait;

    public function __construct(
        private OperationEntityRepository $operationRepository,
    ) {
    }

    public function listenTo(): string
    {
        return AddAccountOperationRequest::class;
    }

    protected function internalVoter($id): void
    {
        /*
         * @var Operation
         */
    }
}
